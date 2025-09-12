<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory {

    protected $model = Product::class;

    public function definition(): array {
        return [
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 1000),
            'unit' => $this->faker->randomElement(['kg', 'm', 'l', 'un']),
            'purchasePrice' => $this->faker->randomFloat(10, 1, 1000)
        ];
    }
}
