<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model {
    public $timestamps = false;

    protected $fillable = [
        "name",
        "quantity",
        "unit",
        "purchasePrice",
        "unitCost"
    ];

    protected $casts = [
        'purchasePrice' => 'decimal:4',
        'unitCost' => 'decimal:6',
    ];

    protected static function booted() {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function procedures() {
        return $this->belongsToMany(Procedure::class, 'material_procedure')
            ->withPivot(['quantityUsed', 'totalCost']);
    }
}
