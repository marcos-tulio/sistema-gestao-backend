<?php

namespace App\Http\Controllers;

use App\Models\PricingProduct;
use App\Models\Product;
use App\Http\Resources\PricingProductResource;

class PricingProductController extends PricingController {

    protected function getModel(): string {
        return PricingProduct::class;
    }

    protected function getModelRelationed(): string {
        return Product::class;
    }

    protected function getResourceRecord(): ?string {
        return PricingProductResource::class;
    }
}
