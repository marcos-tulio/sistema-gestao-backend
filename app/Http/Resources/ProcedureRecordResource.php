<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProcedureRecordResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        // Pega todos os atributos do model
        $data = $this->resource->toArray();

        // Sobrescreve ou adiciona os campos da relação
        $data['materials'] = $this->materials->map(fn($m) => [
            'id'           => $m->id,
            'name'         => $m->name,
            'unit'         => $m->unit,
            'unitCost'     => $m->unitCost,
            'quantityUsed' => $m->pivot->quantityUsed,
            'totalCost'    => $m->pivot->totalCost
        ]);

        return $data;
    }
}
