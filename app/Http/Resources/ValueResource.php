<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ValueResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'year'  => $this->year,
            'month' => $this->month,
            'value' => $this->value,
        ];
    }
}
