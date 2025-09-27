<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PricingProduct extends Pricing {
    use HasFactory;

    protected $table = 'pricing_products';
}
