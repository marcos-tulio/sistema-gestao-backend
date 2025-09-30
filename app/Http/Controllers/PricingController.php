<?php

namespace App\Http\Controllers;

use App\Http\Resources\PricingCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class PricingController extends BaseController {

    abstract protected function getModelRelationed(): string;

    protected function getRelations(): array {
        return [];
    }

    protected function getResourceCollection(): ?string {
        return PricingCollectionResource::class;
    }

    protected function getSorts(): array {
        return [
            'id',
            'name',
            'current.price',
            'current.totalExpenses',
            'current.profitability',
            'current.profitabilityPercentual'
        ];
    }

    protected function sort($query, $sort, $order) {

        $currentFields = ['price', 'totalExpenses', 'profitability', 'profitabilityPercentual'];

        if (str_starts_with($sort, 'current.') && in_array($field = substr($sort, 8), $currentFields)) {
            if ($field === 'profitabilityPercentual') {
                // Calcula o percentual diretamente no banco
                $query->orderBy(
                    $this->getModel()::select(DB::raw('profitability / NULLIF(price,0)'))
                        ->whereColumn('product_id', 'products.id')
                        ->where('isCurrent', true)
                        ->limit(1),
                    $order
                );
            } else $query->orderBy(
                $this->getModel()::select($field)
                    ->whereColumn('product_id', 'products.id')
                    ->where('isCurrent', true)
                    ->limit(1),
                $order
            );
        } else $query = parent::sort($query, $sort, $order);

        return $query;
    }

    public function index(Request $request, $query = null) {
        $query = $query ?: $this->getModelRelationed()::query()->with(['currentPricing']);
        return parent::index($request, $query);
    }

    public function show(string $id) {
        $record = $this->getModelRelationed()::query()->with(['currentPricing', 'latestPricing'])->find($id);

        if (!$record) return response()->json(['message' => 'Item não encontrado'], 404);

        return $this->transformRecord($record);
    }

    protected function getUpdateRules(): array {
        return [
            'current'                                 => 'required|array',
            'current.price'                           => 'required|numeric|min:0',
            'current.commission'                      => 'sometimes|nullable|numeric|min:0',
            'current.taxes'                           => 'sometimes|nullable|numeric|min:0',
            'current.cardTax'                         => 'sometimes|nullable|numeric|min:0',
            'current.includesFixedExpenses'           => 'sometimes|nullable|boolean',
            'current.includesFixedExpensesPercentual' => 'sometimes|nullable|boolean',

            'new'                                     => 'sometimes|nullable|array',
            'new.price'                               => 'sometimes|nullable|numeric|min:0',
            'new.commission'                          => 'sometimes|nullable|numeric|min:0',
            'new.taxes'                               => 'sometimes|nullable|numeric|min:0',
            'new.cardTax'                             => 'sometimes|nullable|numeric|min:0',
            'new.includesFixedExpenses'               => 'sometimes|nullable|boolean',
            'new.includesFixedExpensesPercentual'     => 'sometimes|nullable|boolean'
        ];
    }

    protected function getUpdateValidator(Request $request): array {
        $validated = $request->validate($this->getUpdateRules());

        $validated = array_map(function ($item) {
            if (is_array($item))
                return array_filter($item, fn($value) => !is_null($value));

            return $item;
        }, $validated);

        return $validated;
    }

    public function update(Request $request, string $id) {
        // Pré validação
        $requestValidated = $this->getUpdateRequest($request);
        if (!$requestValidated instanceof Request) return $requestValidated;

        $validated = $this->getUpdateValidator($requestValidated);

        $modelRelationed = $this->getModelRelationed()::query()->with(['currentPricing', 'latestPricing'])->find($id);
        if (!$modelRelationed) return response()->json(['message' => 'Registro não encontrado.'], 404);

        if (isset($validated['current']) && $validated['current']) {
            $validated['current']['isCurrent'] = true;
            $currentPricing = $modelRelationed->currentPricing()->updateOrCreate([], $validated['current']);
            $modelRelationed->setRelation('currentPricing', $currentPricing);
        }

        if (isset($validated['new']) && $validated['new']) {
            $validated['new']['isCurrent'] = false;
            $latestPricing = $modelRelationed->latestPricing()->updateOrCreate([], $validated['new']);
            $modelRelationed->setRelation('latestPricing', $latestPricing);
        }

        //$modelRelationed->save();

        return $this->transformRecord($modelRelationed);
    }

    public function store(Request $request) {
        return response()->json(['message' => 'Método não permitido'], 405);
    }
}
