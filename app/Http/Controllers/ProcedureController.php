<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProcedureResource;
use App\Models\Procedure;
use Illuminate\Http\Request;

class ProcedureController  extends BaseController {

    protected function getModel(): string {
        return Procedure::class;
    }

    protected function getRelations(Request $request): array {
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
}
