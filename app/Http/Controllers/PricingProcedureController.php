<?php

namespace App\Http\Controllers;

use App\Http\Resources\PricingProcedureRecordResource;
use App\Models\PricingProcedure;
use App\Models\Procedure;

class PricingProcedureController extends PricingController {

    protected function getModel(): string {
        return PricingProcedure::class;
    }

    protected function getModelRelationed(): string {
        return Procedure::class;
    }

    protected function getResourceRecord(): ?string {
        return PricingProcedureRecordResource::class;
    }

    protected function getUpdateRules(): array {
        $rules = parent::getUpdateRules();

        $rules['current.includesDirectLabor'] = 'sometimes|nullable|boolean';
        $rules['current.timeSpentInMinutes'] = 'required|numeric|min:0';

        $rules['new.includesDirectLabor'] = 'sometimes|nullable|boolean';
        $rules['new.timeSpentInMinutes'] = 'sometimes|nullable|numeric|min:0';

        return $rules;
    }
}
