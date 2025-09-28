<?php

namespace App\Models;

class PricingProduct extends Pricing {

    protected $table = 'pricing_products';

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
