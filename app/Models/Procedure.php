<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Procedure extends Model {

    public $timestamps = false;

    protected $fillable = [
        'name',
        'materialsCost',
    ];

    protected $casts = [
        'materialsCost' => 'decimal:6'
    ];

    protected $materialsData = [];

    public function setMaterials(array $materials): self {
        $this->materialsData = $materials;
        return $this;
    }

    protected static function booted() {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });

        static::saved(function ($model) {
            if (empty($model->materialsData)) {
                $model->materials()->detach();
                $model->materialsCost = '0';
                $model->saveQuietly();
                return;
            }

            // Busca apenas unitCost dos materiais enviados
            $dbMaterials = Material::whereIn('id', collect($model->materialsData)->pluck('id'))
                ->pluck('unitCost', 'id');

            $pivotData = [];
            $totalCostSum = '0';

            foreach ($model->materialsData as $material) {
                $materialId = $material['id'] ?? null;
                $quantity = $material['quantityUsed'] ?? 0;

                if (!$materialId || !isset($dbMaterials[$materialId])) continue;

                $totalCost = bcmul($quantity, $dbMaterials[$materialId], 6);

                $pivotData[$materialId] = [
                    'quantityUsed' => $quantity,
                    'totalCost' => $totalCost,
                ];

                $totalCostSum = bcadd($totalCostSum, $totalCost, 6);
            }

            // Sincroniza pivot
            $model->materials()->sync($pivotData);

            // Atualiza custo total
            $model->materialsCost = $totalCostSum;
            $model->saveQuietly();
        });
    }

    public function materials() {
        return $this->belongsToMany(Material::class, 'material_procedure')
            ->withPivot(['quantityUsed', 'totalCost']);
    }

    public function currentPricing() {
        return $this->hasOne(PricingProcedure::class)->where('isCurrent', true);
    }

    public function latestPricing() {
        return $this->hasOne(PricingProcedure::class)->latestOfMany()->where('isCurrent', false);
    }
}
