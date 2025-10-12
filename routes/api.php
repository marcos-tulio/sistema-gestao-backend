<?php

use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\FinancialItemController;
use App\Http\Controllers\FinancialItemValueController;
use App\Http\Controllers\FinancialTypeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PricingProcedureController;
use App\Http\Controllers\PricingProductController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/usuario', function () {
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

Route::apiResource('/materiais', MaterialController::class);
Route::apiResource('/produtos', ProductController::class);
Route::apiResource('/procedimentos', ProcedureController::class);
Route::apiResource('/colaboradores', CollaboratorController::class);

Route::apiResource('/precificacao/produtos', PricingProductController::class);
Route::apiResource('/precificacao/procedimentos', PricingProcedureController::class);

Route::patch('/financeiro/valores', [FinancialItemValueController::class, 'updateWithoutId']);
Route::apiResource('/financeiro/valores', FinancialItemValueController::class)->except(['update']);

Route::delete('/financeiro/itens', [FinancialItemController::class, 'destroyMany']);
Route::apiResource('/financeiro/itens', FinancialItemController::class);

Route::apiResource('/financeiro', FinancialTypeController::class)->only(['index', 'show']);
