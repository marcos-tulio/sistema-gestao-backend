<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancialItemCollectionResource extends ResourceCollection {
    public static $wrap = null;

    public function toArray($request) {
        return $this->collection->transform(function ($item) {
            return [
                'id'         => $item->id,
                'categoryId' => $item->financial_category_id,
                'name'       => $item->name,
                'title'      => $item->title,
                'isEditable'  => $item->isEditable,
                'isDeletable' => $item->isDeletable,
            ];
        });
    }
}
