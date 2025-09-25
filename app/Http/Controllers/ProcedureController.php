<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProcedureRecordResource;
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
        return ProcedureRecordResource::class;
    }

    protected function storeMiddleware($validated) {
        // cria o procedimento
        $record = $this->getModel()::create([
            'name' => $validated['name'],
        ]);

        $totalCostSum = '0';

        if (!empty($validated['materials'])) {
            // pega todos os IDs de uma vez
            $materialIds = collect($validated['materials'])->pluck('id')->all();
            $dbMaterials = Material::whereIn('id', $materialIds)->get()->keyBy('id');

            $pivotData = [];

            foreach ($validated['materials'] as $material) {
                $dbMaterial = $dbMaterials[$material['id']];

                $totalCost = bcmul($material['quantityUsed'], $dbMaterial->unitCost, 8);

                $pivotData[$material['id']] = [
                    'quantityUsed' => $material['quantityUsed'],
                    'totalCost' => $totalCost,
                ];

                $totalCostSum = bcadd($totalCostSum, $totalCost, 8);
            }

            // salva no pivô sem duplicar
            $record->materials()->syncWithoutDetaching($pivotData);
        }

        $record->materialsCost = $totalCostSum;
        $record->save();

        return $record->load('materials');
    }

    protected function updateMiddleware($record, $validated) {
        // atualiza campos principais do procedimento
        $record->fill($validated);

        // Verifica se o campo 'materials' foi enviado
        if (array_key_exists('materials', $validated)) {
            $totalCostSum = '0';

            if (!empty($validated['materials'])) {
                // Materiais enviados com itens → sincroniza
                $materialIds = collect($validated['materials'])->pluck('id')->all();
                $dbMaterials = Material::whereIn('id', $materialIds)->get()->keyBy('id');

                $pivotData = [];

                foreach ($validated['materials'] as $material) {
                    $dbMaterial = $dbMaterials[$material['id']];

                    $totalCost = bcmul($material['quantityUsed'], $dbMaterial->unitCost, 8);

                    $pivotData[$material['id']] = [
                        'quantityUsed' => $material['quantityUsed'],
                        'totalCost' => $totalCost,
                    ];

                    $totalCostSum = bcadd($totalCostSum, $totalCost, 8);
                }

                $record->materials()->sync($pivotData);
            } else {
                $record->materials()->detach();
            }

            // Atualiza o custo total se materiais foram enviados
            $record->materialsCost = $totalCostSum;
        }

        $record->save();

        return $record->load('materials');
    }
}
