<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\RefreshToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {

    public function callbackGoogle(Request $request) {
        $requestValidated = $request->validate([
            'code' => 'required|string'
        ]);

        $response = Http::asForm()->post(
            'https://oauth2.googleapis.com/token',
            [
                'code'          => $requestValidated['code'],
                'client_id'     => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri'  => config('services.google.redirect'),
                'grant_type'    => 'authorization_code',
            ]
        );

        if ($response->failed()) {
            if ($response->status() == 400)
                return response()->json(['error' => 'Requisição inválida'], 400);

            return response()->json(['error' => $response->json()], $response->status());
        }

        $data = $response->json();

        $googleUser = explode('.', $data['id_token'])[1];
        $googleUser = json_decode(base64_decode(strtr($googleUser, '-_', '+/')), true);

        $user = User::firstOrCreate(
            [
                'googleEmail' => $googleUser['email']
            ],
            [
                'name'        => $googleUser['name'],
                'email'       => $googleUser['email'],
                'image'       => $googleUser['picture'],
                'password'    => bcrypt(Str::random(32)),
                'googleName'  => $googleUser['name'],
                'googleEmail' => $googleUser['email'],
                'googleImage' => $googleUser['picture'],
            ]
        );

        // Necessario atualizar os dados da conta google
        if ($user->googleEmail !== $googleUser['email'] || $user->googleName !== $googleUser['name']) {
            $user->googleEmail = $googleUser['email'];
            $user->googleName = $googleUser['name'];
            $user->save();
        }

        // Ao fazer um login com sucesso, todos os refresh tokens serão apagados.
        $deviceId = $request->cookie('deviceId') ?? (string) Str::uuid();

        $token = Auth::guard('api')->login($user);
        $refreshToken = Str::random(64);

        $this->createRefreshToken($user->id, $deviceId, $refreshToken);

        return $this->getResponseToken($user, $deviceId, $token, $refreshToken);
    }

    public function refresh(Request $request) {
        $refreshToken = $request->cookie('refreshToken');
        $deviceId = $request->cookie('deviceId');

        if (! $refreshToken || ! $deviceId)
            return response()->json(['message' => 'Acesso não autorizado!'], 401);

        $tokenHash = hash('sha256', $refreshToken);

        $storedToken = RefreshToken::where('token', $tokenHash)
            ->where('expires_at', '>', now())
            ->where('device_id', $deviceId)
            ->first();

        if (!$storedToken)
            return response()->json(['message' => 'Acesso não autorizado!'], 401);

        $newRefreshToken = Str::random(64);

        $this->createRefreshToken($storedToken->user_id, $deviceId, $newRefreshToken);

        $accessToken = JWTAuth::fromUser($storedToken->user);

        return $this->getResponseToken($storedToken->user, $deviceId, $accessToken, $newRefreshToken);
    }

    public function me() {
        return response()->json(Auth::user());
    }

    public function logout(Request $request) {

        if ($token = $request->cookie('refreshToken'))
            RefreshToken::where('token', hash('sha256', $token))->delete();

        return response()
            ->json(['message' => 'Usuário deslogado com sucesso'])
            ->withoutCookie('refreshToken');
    }

    private function createRefreshToken($userId, $deviceId, $token) {
        RefreshToken::updateOrCreate(
            [
                'user_id'   => $userId,
                'device_id' => $deviceId,
            ],
            [
                'token'      => hash('sha256', $token),
                'expires_at' => now()->addDays(config('jwt.refresh_days')),
            ]
        );
    }

    private function getResponseToken($user, $deviceId, $accessToken, $refreshToken) {
        return response()
            ->json([
                'user'  => UserResource::make($user),
                'token' => [
                    'accessToken' => $accessToken,
                    'tokenType'   => 'Bearer',
                    'expiresIn'   => (int) config('jwt.ttl')
                ]
            ])
            ->cookie(
                'refreshToken',
                $refreshToken,
                (int) config('jwt.refresh_ttl'),
                '/',
                null,
                env('JWT_COOKIE_SECURE', true),
                true,
                false,
                'Strict'
            )
            ->cookie(
                'deviceId',
                $deviceId,
                525600,
                '/',
                null,
                env('JWT_COOKIE_SECURE', true),
                true,
                false,
                'Strict'
            );
    }
}
