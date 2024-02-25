<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'profit_margin' => $this->faker->randomFloat(2, 0.1, 0.5),
            'shipping_cost' => $this->faker->randomFloat(2, 5, 20),
        ];
    }
}
