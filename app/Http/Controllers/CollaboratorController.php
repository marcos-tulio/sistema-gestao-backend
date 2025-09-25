<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollaboratorCollectionResource;
use App\Models\Collaborator;

class CollaboratorController extends BaseController {

    protected function getModel(): string {
        return Collaborator::class;
    }

    protected function getResourceCollection(): ?string {
        return CollaboratorCollectionResource::class;
    }

    protected function getStoreRules(): array {
        return [
            'name' => 'required|string|max:255',
            'profession' => 'sometimes|nullable|string|max:255',
            'type' => 'required|string|size:1|in:s,a,p',

            'includesDirectLabor' => 'sometimes|boolean',
            'minutesWorked' => 'required_if:includesDirectLabor,true|nullable|integer|min:0',
            'daysWorked'    => 'required_if:includesDirectLabor,true|nullable|integer|min:0',

            'paymentAmount'    => 'required|numeric|min:0',
            'payment13'        => 'sometimes|nullable|numeric|min:0',
            'transportVoucher' => 'sometimes|nullable|numeric|min:0',
            'foodVoucher'      => 'sometimes|nullable|numeric|min:0',
            'healthInsurance'  => 'sometimes|nullable|numeric|min:0',
            'laborCosts'       => 'sometimes|nullable|numeric|min:0',
            'others'           => 'sometimes|nullable|numeric|min:0',
        ];
    }

    protected function getUpdateRules(): array {
        return [
            'name'       => 'sometimes|string|max:255',
            'profession' => 'sometimes|nullable|string|max:255',
            'type'       => 'sometimes|string|size:1|in:s,a,p',

            'includesDirectLabor' => 'sometimes|boolean',
            'minutesWorked'       => 'sometimes:includesDirectLabor,true|nullable|integer|min:0',
            'daysWorked'          => 'sometimes:includesDirectLabor,true|nullable|integer|min:0',

            'paymentAmount'    => 'sometimes|numeric|min:0',
            'payment13'        => 'sometimes|nullable|numeric|min:0',
            'transportVoucher' => 'sometimes|nullable|numeric|min:0',
            'foodVoucher'      => 'sometimes|nullable|numeric|min:0',
            'healthInsurance'  => 'sometimes|nullable|numeric|min:0',
            'laborCosts'       => 'sometimes|nullable|numeric|min:0',
            'others'           => 'sometimes|nullable|numeric|min:0',
        ];
    }

    protected function getSorts(): array {
        return ['id', 'profession', 'name', 'type', 'costDirectLaborPerMinute', 'totalCost'];
    }

    protected function storeMiddleware($validated) {
        if (!array_key_exists('includesDirectLabor', $validated) || !$validated['includesDirectLabor'])
            $validated['includesDirectLabor'] = false;

        if ($validated['type'] == 'a' && $validated['includesDirectLabor'])
            return response()->json(['message' => 'Um assalariado não pode possuir cálculo de Mão de Obra Direta'], 400);

        return $this->getModel()::create($validated);
    }

    protected function updateMiddleware($record, $validated) {
        if (!array_key_exists('includesDirectLabor', $validated) || !$validated['includesDirectLabor'])
            $validated['includesDirectLabor'] = false;

        if (array_key_exists('type', $validated) && $validated['type'] == 'a' && $validated['includesDirectLabor'])
            return response()->json(['message' => 'Um assalariado não pode possuir cálculo de Mão de Obra Direta'], 400);

        $record->fill($validated);
        $record->save();

        return $record;
    }
}
