<?php

namespace App\Http\Resources;

class PricingProcedureRecordResource extends PricingRecordResource {

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
