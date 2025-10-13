<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinancialCategoryCollectionResource;
use App\Http\Resources\FinancialCategoryResource;
use App\Models\FinancialCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialCategoryController extends BaseController {

    protected function getModel(): string {
        return FinancialCategory::class;
    }

    protected function getResourceRecord(): ?string {
        return FinancialCategoryResource::class;
    }

    protected function getResourceCollection(): ?string {
        return FinancialCategoryCollectionResource::class;
    }

    protected function getStoreRules(): array {
        return [
            'typeId' => 'required|integer|exists:financial_types,id',
            'title'  => 'required|string|max:255',
            'order'  => 'nullable|integer|min:1',
        ];
    }

    protected function getUpdateRules(): array {
        return [
            'title'  => 'required|string|max:255',
            'order'  => 'nullable|integer|min:1',
        ];
    }

    protected function storeMiddleware($validated) {
        $validated['financial_type_id'] = $validated['typeId'];

        return $this->getModel()::create($validated);
    }

    public function index(Request $request, $query = null) {
        $modelClass = $this->getModel();
        $query = $modelClass::query()->orderBy('order');

        if (!$request->has('typeId'))
            return parent::index($request, $query);

        $request->merge(['financial_type_id' => $request->get('typeId')]);

        return parent::index($request, $query);
    }

    public function updateMany(Request $request) {
        try {
            $validated = $request->validate([
                'categories'        => 'required|array|min:1',
                'categories.*.id'   => 'required|integer|exists:financial_categories,id',
                'categories.*.order' => 'required|integer',
            ]);

            // Agrupa IDs por order
            $groups = collect($validated['categories'])
                ->groupBy('order') // chave = order, valor = coleção de categorias
                ->map(fn($items) => $items->pluck('id')->toArray());

            DB::transaction(function () use ($groups) {
                foreach ($groups as $order => $ids)
                    FinancialCategory::whereIn('id', $ids)->update(['order' => $order]);
            });

            return response()->json(['message' => 'Categorias atualizadas com sucesso.']);
        } catch (\Exception $e) {
            return $this->errorHandler($e);
        }
    }

    public function destroy(string $id): JsonResponse {

        return parent::destroy($id);
    }
}
