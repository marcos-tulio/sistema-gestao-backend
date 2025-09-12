<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends BaseController {

    protected function getModel(): string {
        return Material::class;
    }

    protected function getRules(): array {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:1',
            'unit' => 'required|string|max:10',
            'purchasePrice' => 'required|numeric|gt:0',
        ];
    }

    protected function getValidator(Request $request): array {
        $validated = $request->validate($this->getRules());
        $validated['unitCost'] = bcdiv($validated['purchasePrice'], $validated['quantity'], 8);
        return $validated;
    }

    protected function getSorts(): array {
        return ['id', 'name', 'quantity', 'unit', 'purchasePrice', 'unitCost'];
    }
}
