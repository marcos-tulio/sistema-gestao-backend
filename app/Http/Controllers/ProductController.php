<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends BaseController {
    protected function getModel(): string {
        return Product::class;
    }

    protected function getStoreRules(): array {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:1',
            'unit' => 'required|string|max:10',
            'purchasePrice' => 'sometimes|numeric|min:0',
        ];
    }

    protected function getUpdateRules(): array {
        return [
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|numeric|min:1',
            'unit' => 'sometimes|string|max:10',
            'purchasePrice' => 'sometimes|numeric|min:0',
        ];
    }

    protected function getSorts(): array {
        return ['id', 'name', 'quantity', 'unit', 'purchasePrice'];
    }
}
