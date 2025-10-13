<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancialCategoryCollectionResource extends ResourceCollection {
    public static $wrap = null;

    public function toArray($request) {
        return $this->collection->transform(function ($item) {
            return [
                'id'     => $item->id,
                'typeId' => $item->financial_type_id,
                'title'  => $item->title,
                'order'  => $item->order,
                'isDeletable' => $item->isDeletable,
                'isEditable'  => $item->isEditable
            ];
        });
    }
}
