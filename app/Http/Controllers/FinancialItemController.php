<?php

namespace App\Http\Controllers;

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

    protected function getRelations(Request $request): array {
        return ['category', 'values'];
    }

    protected function getStoreRules(): array {
        return [
            'categoryId' => 'required|integer|exists:financial_categories,id',
            'title' => 'required|string|max:255',
        ];
    }

    protected function storeMiddleware($validated) {
        $validated['financial_category_id'] = $validated['categoryId'];
        $validated['isEditable'] = true;

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

            $existingIds = $this->getModel()::whereIn('id', $ids)->pluck('id')->toArray();

            $deletedCount = $this->getModel()::whereIn('id', $existingIds)->delete();

            return response()->json([
                'message' => "{$deletedCount} registros removidos com sucesso",
                'deletedCount' => $deletedCount,
                'deletedIds' => $existingIds
            ]);
        } catch (\Exception $e) {
            return $this->errorHandler($e);
        }
    }
}
