<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollaboratorCollectionResource extends JsonResource {

    public static $wrap = null;

    public function toArray(Request $request): array {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "profession" => $this->profession,
            "totalCost" => $this->totalCost,
            "costDirectLaborPerMinute" => $this->costDirectLaborPerMinute,
        ];
    }
}
