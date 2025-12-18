<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'name'        => $this->googleName,
            'email'       => $this->googleEmail,
            'image'       => $this->googleImage,

            'googleName'  => $this->googleImage,
            'googleEmail' => $this->googleEmail,
            'googleImage' => $this->googleImage,
        ];
    }
}
