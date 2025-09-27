<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "quantity",
        "unit",
        "purchasePrice",
        "isCurrent"
    ];

    protected static function booted() {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    protected $casts = [
        'purchasePrice' => 'decimal:4'
    ];

    public function pricingProducts() {
        return $this->hasMany(PricingProduct::class);
    }

    public function currentPricing() {
        return $this->hasOne(PricingProduct::class)->where('isCurrent', true);
    }

    public function latestPricing() {
        return $this->hasOne(PricingProduct::class)->latestOfMany()->where('isCurrent', false);
    }
}
