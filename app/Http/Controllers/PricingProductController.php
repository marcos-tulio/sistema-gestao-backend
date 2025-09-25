<?php

namespace App\Http\Controllers;

use App\Models\PricingProduct;
use App\Models\Product;
use App\Http\Resources\PricingProductCollectionResource;
use App\Http\Resources\PricingProductRecordResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingProductController extends BaseController {

    protected function getModel(): string {
        return PricingProduct::class;
    }

    protected function getResourceRecord(): ?string {
        return PricingProductRecordResource::class;
    }

    protected function getResourceCollection(): ?string {
        return PricingProductCollectionResource::class;
    }

    protected function getRelations(): array {
        return [];
    }

    protected function getSorts(): array {
        return ['id', 'name', 'current.price', 'current.totalExpenses', 'current.profitability', 'current.profitabilityPercentual'];
    }

    protected function sort($query, $sort, $order) {

        $currentFields = ['price', 'totalExpenses', 'profitability', 'profitabilityPercentual'];

        if (str_starts_with($sort, 'current.') && in_array($field = substr($sort, 8), $currentFields)) {
            if ($field === 'profitabilityPercentual') {
                // Calcula o percentual diretamente no banco
                $query->orderBy(
                    PricingProduct::select(DB::raw('profitability / NULLIF(price,0)'))
                        ->whereColumn('product_id', 'products.id')
                        ->where('isCurrent', true)
                        ->limit(1),
                    $order
                );
            } else $query->orderBy(
                PricingProduct::select($field)
                    ->whereColumn('product_id', 'products.id')
                    ->where('isCurrent', true)
                    ->limit(1),
                $order
            );
        } else $query = parent::sort($query, $sort, $order);

        return $query;
    }

    public function index(Request $request, $query = null) {
        $query = $query ?: Product::query()->with(['currentPricing']);
        return parent::index($request, $query);
    }

    public function show(string $id) {
        $record = Product::query()->with(['currentPricing', 'latestPricing'])->find($id);

        if (!$record) return response()->json(['message' => 'Item não encontrado'], 404);

        return $this->transformRecord($record);
    }

    protected function getUpdateRules(): array {
        return [
            'current' => 'sometimes|array',
            'current.price' => 'required_with:current|numeric|min:0',
            'current.commission' => 'required_with:current|numeric|min:0',
            'current.taxes' => 'required_with:current|numeric|min:0',
            'current.cardTax' => 'required_with:current|numeric|min:0',
            'current.includesFixedExpenses' => 'required_with:current|boolean',
            'current.includesFixedExpensesPercentual' => 'required_with:current|boolean',

            'new' => 'sometimes|array',
            'new.price' => 'required_with:new|numeric|min:0',
            'new.commission' => 'required_with:new|numeric|min:0',
            'new.taxes' => 'required_with:new|numeric|min:0',
            'new.cardTax' => 'required_with:new|numeric|min:0',
            'new.includesFixedExpenses' => 'required_with:new|boolean',
            'new.includesFixedExpensesPercentual' => 'required_with:new|boolean'
        ];
    }

    /*public function update(Request $request, string $id) {
        dd($request->all());
    }*/

    protected function updateMiddleware($record, $validated) {
        dd($validated, $record);
        /*$record->fill($validated);
        $record->save();*/
        return $record;
    }


    public function store(Request $request) {
        return response()->json(['message' => 'Método não permitido'], 405);
    }
}
