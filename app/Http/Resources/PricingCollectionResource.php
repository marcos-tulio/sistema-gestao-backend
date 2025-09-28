<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PricingCollectionResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'current' => $this->currentPricing ? [
                'price'         => $this->currentPricing->price,
                'totalExpenses' => $this->currentPricing->totalExpenses,
                'profitability' => $this->currentPricing->profitability,
                'profitabilityPercentual' => $this->currentPricing->profitabilityPercentual,
            ] : [],
        ];
    }
}
