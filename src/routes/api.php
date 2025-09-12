<?php

use App\Http\Controllers\MaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/user', function () {
    return response()->json([
        "id" => 1,
        "name" => "Lucas",
        "email" => "lucas@lucas",
        "image" => "https://picsum.photos/id/64/300/400.jpg",
        "business" => [
            "name" => "Salão da Mancini",
            "logo" => "https://blog.agenciadosite.com.br/wp-content/uploads/2017/02/logo-mancini-e1486727339396.jpg"
        ]
    ]);
});

Route::apiResource('/materials', MaterialController::class);
