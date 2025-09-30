<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PricingCollectionResource extends ResourceCollection {

    public static $wrap = null;

    public function toArray($request) {
        return $this->collection->transform(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'current' => $item->currentPricing ? [
                    'price'         => $item->currentPricing->price,
                    'totalExpenses' => $item->currentPricing->totalExpenses,
                    'profitability' => $item->currentPricing->profitability,
                    'profitabilityPercentual' => $item->currentPricing->profitabilityPercentual,
                ] : []
            ];
        });
    }
}
