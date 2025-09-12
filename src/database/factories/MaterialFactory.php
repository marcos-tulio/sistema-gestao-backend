<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory {

    protected $model = Material::class;

    public function definition() {
        $purchasePrice = $this->faker->randomFloat(10, 1, 1000); // preço de compra
        $quantity = $this->faker->numberBetween(1, 1000);

        return [
            'name' => $this->faker->word(),                       // nome do material
            'quantity' => $quantity,                               // quantidade
            'unit' => $this->faker->randomElement(['kg', 'm', 'l', 'un']), // unidade
            'purchasePrice' => $purchasePrice,                    // preço de compra
            'unitCost' => $purchasePrice / $quantity,             // custo unitário
        ];
    }
}
