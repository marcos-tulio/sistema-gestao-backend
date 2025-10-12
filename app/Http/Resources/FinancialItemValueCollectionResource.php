<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancialItemValueCollectionResource extends ResourceCollection {
    public static $wrap = null;

    public function toArray($request) {
        return $this->collection->transform(function ($item) {
            return [
                'id'     => $item->id,
                'itemId' => $item->financial_item_id,
                'year'   => $item->year,
                'month'  => $item->month,
                'value'  => $item->value
            ];
        });
    }
}
