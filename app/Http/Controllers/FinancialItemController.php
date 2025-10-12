<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinancialItemCollectionResource;
use App\Http\Resources\FinancialItemResource;
use App\Models\FinancialItem;
use Illuminate\Http\Request;

class FinancialItemController extends BaseController {

    protected function getModel(): string {
        return FinancialItem::class;
    }

    protected function getResourceRecord(): ?string {
        return FinancialItemResource::class;
    }

    protected function getResourceCollection(): ?string {
        return FinancialItemCollectionResource::class;
    }

    protected function getRelations(Request $request): array {
        return ['category', 'values'];
    }

    protected function getStoreRules(): array {
        return [
            'categoryId' => 'required|integer|exists:financial_categories,id',
            'title' => 'required|string|max:255',
        ];
    }

    protected function getUpdateRules(): array {
        return [
            'title' => 'required|string|max:255',
        ];
    }

    protected function storeMiddleware($validated) {
        $validated['financial_category_id'] = $validated['categoryId'];

        return $this->getModel()::create($validated);
    }

    public function destroyMany(Request $request) {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer',
            ]);

            $ids = $validated['ids'];
            if (empty($ids)) return response()->json(['message' => 'Nenhum ID informado'], 400);

            // Pega os itens deletáveis com relações carregadas
            $items = $this->getModel()::whereIn('id', $ids)
                ->where('isDeletable', true)
                ->with('values.item.category.type')
                ->get();

            if ($items->isEmpty()) return response()->json(['message' => 'Nenhum registro deletável encontrado'], 400);

            $deletedIds = $items->pluck('id')->toArray();

            // Pega todos os FinancialItemValues relacionados antes do delete
            $values = $items->flatMap(fn($item) => $item->values);

            // Agrupa por type/ano/mês para evitar recalculos repetidos
            $groups = $values->map(fn($value) => [
                'value' => $value,
                'key' => $value->item?->category?->type?->id . '_' . $value->year . '_' . $value->month,
            ])
                ->filter(fn($g) => $g['value']->item?->category?->type?->id !== null)
                ->unique('key')
                ->pluck('value');

            // Deleta todos os itens em massa
            $this->getModel()::whereIn('id', $deletedIds)
                ->where('isDeletable', true)
                ->delete();

            // Dispara o observer manualmente apenas uma vez por grupo
            $observer = app(\App\Observers\FinancialItemValueObserver::class);
            foreach ($groups as $value) $observer->recalculateTypeTotal($value);

            return response()->json([
                'message'      => count($deletedIds) . " registros removidos com sucesso",
                'deletedCount' => count($deletedIds),
                'deletedIds'   => $deletedIds,
            ]);
        } catch (\Exception $e) {
            return $this->errorHandler($e);
        }
    }
}
