<?php

namespace App\Http\Resources;

class PricingProcedureResource extends PricingResource {

    protected function getRelationsFields(): array {
        $fields = parent::getRelationsFields();

        array_push(
            $fields,
            'includesDirectLabor',
            'timeSpentInMinutes'
        );

        return $fields;
    }
}
