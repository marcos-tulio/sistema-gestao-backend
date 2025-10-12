<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialItemValueResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'id'     => $this->id,
            'itemId' => $this->financial_item_id,
            'year'   => $this->year,
            'month'  => $this->month,
            'value'  => $this->value
        ];
    }
}
