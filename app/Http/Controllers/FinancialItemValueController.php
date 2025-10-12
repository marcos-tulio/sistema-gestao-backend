<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinancialItemValueCollectionResource;
use App\Http\Resources\FinancialItemValueResource;
use App\Models\FinancialItemValue;
use Illuminate\Http\Request;

class FinancialItemValueController extends BaseController {

    protected function getModel(): string {
        return FinancialItemValue::class;
    }

    protected function getResourceCollection(): ?string {
        return FinancialItemValueCollectionResource::class;
    }

    protected function getResourceRecord(): ?string {
        return FinancialItemValueResource::class;
    }

    protected function getRelations(Request $request): array {
        return ['item'];
    }

    protected function getStoreRules(): array {
        return [
            'itemId' => 'required|numeric|exists:financial_items,id',
            'year'   => 'required|numeric|min:1900',
            'month'  => 'required|numeric|between:1,12',
            'value'  => 'required|numeric',
        ];
    }

    protected function getUpdateRules(): array {
        return [
            'itemId' => 'required|numeric|exists:financial_items,id',
            'value'  => 'nullable|numeric',
            'year'   => 'required|numeric|min:1900',
            'month'  => 'required|numeric|between:1,12',
        ];
    }

    protected function storeMiddleware($validated) {
        $validated['financial_item_id'] = $validated['itemId'];
        return $this->getModel()::create($validated);
    }

    public function updateWithoutId(Request $request) {
        try {
            $requestValidated = $this->getUpdateRequest($request);
            if (!$requestValidated instanceof Request) return $requestValidated;

            $validated = $this->getUpdateValidator($requestValidated);

            $record = $this->getModel()::where('financial_item_id', $validated['itemId'])
                ->where('year', $validated['year'])
                ->where('month', $validated['month'])
                ->first();

            if (is_null($validated['value'])) {
                if (!$record) {
                    $record = $this->getModel()::newModelInstance();
                    $record->fill($validated);
                    $record->financial_item_id = $validated['itemId'];
                } else {
                    $this->destroy($record->id);
                    $record->value = null;
                }
            } else $record = $record ? $this->updateMiddleware($record, $validated) : $this->storeMiddleware($validated);

            return $this->transformRecord($record);
        } catch (\Exception $e) {
            return $this->errorHandler($e);
        }
    }
}
