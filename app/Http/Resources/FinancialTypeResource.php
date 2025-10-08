<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialTypeResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'title'      => $this->title,
            'isIncome'   => $this->isIncome,
            'categories' => FinancialCategoryResource::collection($this->categories),
        ];
    }
}
