<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProcedureResource;
use App\Models\Material;
use App\Models\Procedure;

class ProcedureController  extends BaseController {

    protected function getModel(): string {
        return Procedure::class;
    }

    protected function getRelations(): array {
        return ['materials'];
    }

    protected function getStoreRules(): array {
        return [
            'name' => 'required|string|max:255',
            'materials' => 'sometimes|array',
            'materials.*.id' => 'required_with:materials|integer|exists:materials,id',
            'materials.*.quantityUsed' => 'required_with:materials|numeric|min:1',
        ];
    }

    protected function getSorts(): array {
        return ['id', 'name'];
    }

    protected function getResourceRecord(): ?string {
        return ProcedureResource::class;
    }

    protected function storeMiddleware($validated) {
        $procedure = (new Procedure(['name' => $validated['name']]));
        $procedure->setMaterials($validated['materials'] ?? []);
        $procedure->save();

        return $procedure->load('materials');
    }

    protected function updateMiddleware($record, $validated) {
        $record->fill(['name' => $validated['name']]);
        $record->setMaterials($validated['materials'] ?? []);
        $record->save();

        return $record->load('materials');
    }

    /*protected function storeMiddleware($validated) {
        // cria o procedimento
        $record = $this->getModel()::create([
            'name' => $validated['name'],
        ]);

        [$pivotData, $totalCostSum] = $this->prepareMaterialsPivot($validated['materials']);
        $record->materials()->sync($pivotData);
        $record->materialsCost = $totalCostSum;
        $record->save();

        return $record->load('materials');
    }

    protected function updateMiddleware($record, $validated) {
        // atualiza campos principais do procedimento
        $record->fill($validated);

        [$pivotData, $totalCostSum] = $this->prepareMaterialsPivot($validated['materials']);
        $record->materials()->sync($pivotData);
        $record->materialsCost = $totalCostSum;
        $record->save();

        return $record->load('materials');
    }

    private function prepareMaterialsPivot(array $materials): array {
        $pivotData = [];
        $totalCostSum = '0';

        $dbMaterials = Material::whereIn('id', collect($materials)->pluck('id'))->get()->keyBy('id');

        foreach ($materials as $material) {
            $dbMaterial = $dbMaterials[$material['id']];
            $totalCost = bcmul($material['quantityUsed'], $dbMaterial->unitCost, 8);

            $pivotData[$material['id']] = [
                'quantityUsed' => $material['quantityUsed'],
                'totalCost' => $totalCost,
            ];

            $totalCostSum = bcadd($totalCostSum, $totalCost, 8);
        }

        return [$pivotData, $totalCostSum];
    }*/
}
