<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialItemResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'id'     => $this->id,
            'title'  => $this->title,
            'isEditable' => $this->isEditable,
            'values' => ValueResource::collection($this->values),
        ];
    }
}
