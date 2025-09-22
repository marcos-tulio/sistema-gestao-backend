<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Procedure extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'materialsCost',
    ];

    protected $casts = [
        'materialsCost' => 'decimal:8'
    ];

    protected static function booted() {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function materials() {
        return $this->belongsToMany(Material::class, 'material_procedure')
            ->withPivot(['quantityUsed', 'totalCost']);
    }
}
