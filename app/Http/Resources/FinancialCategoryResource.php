<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialCategoryResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'id'     => $this->id,
            'title'  => $this->title,
            'order'  => $this->order,
            'values' => ValueResource::collection($this->values),
        ];
    }
}
