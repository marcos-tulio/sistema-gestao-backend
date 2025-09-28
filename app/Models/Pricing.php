<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Pricing extends Model {

    public $timestamps = false;

    protected $fillable = [
        "price",
        "commission",
        "taxes",
        "cardTax",
        "includesFixedExpenses",
        "includesFixedExpensesPercentual",
        "isCurrent",
        "includesDirectLabor",
        "timeSpentInMinutes",
    ];

    protected $casts = [
        'price'              => 'decimal:4',
        'commission'         => 'decimal:4',
        'taxes'              => 'decimal:4',
        'cardTax'            => 'decimal:4',

        'variableExpenses'   => 'decimal:6',
        'fixedExpenses'      => 'decimal:6',
        'totalExpenses'      => 'decimal:6',
        'contributionMargin' => 'decimal:6',
        'profitability'      => 'decimal:6',
    ];

    public function getProfitabilityPercentualAttribute() {
        if ($this->price == 0 || $this->price === null) return null;

        return bcdiv($this->profitability, $this->price, 4);
    }

    protected static function booted() {
        static::saving(function ($model) {
            // Despesas variáveis
            $model->variableExpenses = $model->calculateVariableExpenses();

            // Despesas fixas
            $model->fixedExpenses = $model->calculateFixedExpenses();

            // Total das despesas
            $model->totalExpenses = bcadd(
                $model->variableExpenses ?? 0,
                $model->fixedExpenses ?? 0,
                6
            );

            // Margem de contribuição
            $model->contributionMargin = bcsub(
                $model->price ?? 0,
                $model->variableExpenses ?? 0,
                6
            );

            // Lucratividade
            $model->profitability = bcsub(
                $model->price ?? 0,
                $model->totalExpenses ?? 0,
                6
            );
        });
    }

    protected function calculateFixedExpenses(): string {
        if (!$this->includesFixedExpenses)
            return "0";

        // fazer o calculo com o resumo financeiro
        if ($this->includesFixedExpensesPercentual)
            return bcadd(10, 0, 6);

        return bcadd(10, 0, 6);

        /*

        // Despesas Fixas
        const fixedExpensesPercentageComputed = computed(() =>{
            if ( !data.value.includesFixedExpenses )
                return 0

            // Cálculo por Percentual
            if ( data.value.includesFixedExpensesPercentual )
                return Decimal(props.financial.fixedExpensesByRevenue.average).mul(100).toNumber()

            // Cálculo por Hora
            const valueCurrency = 
                    Decimal(props.financial.fixedExpensesByDirectLaborMinutes.average)
                    .mul(data.value.timeSpent ?? 0)

            // Cálculo por Hora em porcentagem
            return valueCurrency.div(data.value.price || 1).mul(100).toNumber()
        })
        
        */
    }

    protected function calculateVariableExpenses(): string {
        // Custo
        $cost = 0;

        // Custo do produto
        $product = $this->product;
        if ($product) $cost = bcadd($cost, $product->purchasePrice ?? 0, 6);

        // taxas -> (comissao + cartao + impostos)/100
        $percentual = bcadd($this->commission ?? 0, $this->cardTax ?? 0, 6);
        $percentual = bcadd($percentual, $this->taxes ?? 0, 6);
        $percentual = bcdiv($percentual, 100, 6);

        // Todo: incluir MOD no filho


        // Total -> (custo + (preco * percentual))
        $total = bcmul($this->price ?? 0, $percentual, 6);
        $total = bcadd($total, $cost, 6);

        return $total;
    }

    //abstract public function cost();
}
