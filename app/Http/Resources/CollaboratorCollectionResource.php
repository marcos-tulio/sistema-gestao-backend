<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CollaboratorCollectionResource extends ResourceCollection {

    public static $wrap = null;

    public function toArray($request) {
        return $this->collection->transform(function ($item) {
            return [
                "id" => $item->id,
                "name" => $item->name,
                "profession" => $item->profession,
                "totalCost" => $item->totalCost,
                "costDirectLaborPerMinute" => $item->costDirectLaborPerMinute,
            ];
        });
    }
}
