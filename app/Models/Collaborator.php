<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collaborator extends Model {

    public $timestamps = false;

    /*
        Tipo de colaborador:
            s = Sócio/Dono
            a = assalariado
            p = prestador de serviços
    
    */

    protected $fillable = [
        "name",
        "profession",
        "type",
        "includesDirectLabor",
        "minutesWorked",
        "daysWorked",
        "paymentAmount",
        "payment13",
        "transportVoucher",
        "foodVoucher",
        "healthInsurance",
        "laborCosts",
        "others"
    ];

    protected $casts = [
        'totalCost' => 'decimal:2',
        'daysWorked' => 'decimal:2',
        'minutesWorked' => 'integer',
        'costDirectLaborPerMinute' => 'decimal:8',
    ];

    protected static function booted() {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);

            // Calcular o total
            $total = $model->paymentAmount;

            $numericFields = [
                'payment13',
                'transportVoucher',
                'foodVoucher',
                'healthInsurance',
                'laborCosts',
                'others',
            ];

            foreach ($numericFields as $field) {
                $value = $model->{$field} ?? 0;
                $total = bcadd($total, $value, 6);
            }

            $model->totalCost = $total;


            // Calcular MOD
            if ($model->includesDirectLabor) {
                $model->daysWorked = $model->daysWorked ?? 0;
                $model->minutesWorked = $model->minutesWorked ?? 0;
                $model->costDirectLaborPerMinute = 0;

                $model->totalMinutesWorked = bcmul($model->minutesWorked, $model->daysWorked, 2);

                if (bccomp($model->totalMinutesWorked, '0', 2) === 1) {
                    $model->costDirectLaborPerMinute = bcdiv($model->totalCost, $model->totalMinutesWorked, 8);
                }
            } else {
                $model->minutesWorked = null;
                $model->daysWorked = null;
                $model->totalMinutesWorked = null;
                $model->costDirectLaborPerMinute = null;
            }
        });
    }
}
