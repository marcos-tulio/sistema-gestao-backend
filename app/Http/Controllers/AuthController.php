<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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

        /* // Necessario atualizar os dados da conta google
        if ($user->googleEmail !== $googleUser['email'] || $user->googleName !== $googleUser['name']) {
            
        }
        */

        $token = Auth::guard('api')->login($user);

        return response()->json([
            'user'  => UserResource::make($user),
            'token' => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => config('jwt.ttl') * 60,
            ]
        ]);
    }

    public function loginGoogle(Request $request) {
        $request->validate([
            'code' => 'required|string'
        ]);

        $googleResponse = Http::asForm()->post(
            'https://oauth2.googleapis.com/token',
            [
                'code' => $request->code,
                'client_id'     => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri'  => config('services.google.redirect'),
                'grant_type'    => 'authorization_code',
            ]
        );

        if (!$googleResponse->successful()) {
            return response()->json([
                'message' => 'Erro ao autenticar com o Google',
                'error' => $googleResponse->json(),
            ], 401);
        }

        $googleToken = $googleResponse->json();

        $payload = json_decode(
            base64_decode(strtr(
                explode('.', $googleToken['id_token'])[1],
                '-_',
                '+/'
            )),
            true
        );

        $name =
            trim($payload['name'] ?? '') !== ''
            ? $payload['name']
            : ($payload['given_name']
                ?? explode('@', $payload['email'])[0]);

        $user = User::firstOrCreate(
            ['googleEmail' => $payload['email']],
            [
                'name' => $name,
                'googleImage' => $payload['picture'] ?? null,
                'password' => bcrypt(Str::random(32)),
            ]
        );

        $token = $user->createToken('web')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function me() {
        return response()->json(Auth::user());
    }

    public function logout() {
        Auth::logout();
        return response()->json(['message' => 'Logout realizado']);
    }

    public function refresh() {
        return response()->json([
            'access_token' => Auth::refresh()
        ]);
    }
}
