<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancialTypeCollectionResource extends ResourceCollection {
    public static $wrap = null;

    public function toArray($request) {
        return $this->collection->transform(function ($item) {
            return [
                'id'       => $item->id,
                'name'     => $item->name,
                'title'    => $item->title,
                'isIncome' => $item->isIncome,
                'values'   => ValueResource::collection($item->values),
            ];
        });
    }
}
