<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'year'    => null,
        ];
    }
}
