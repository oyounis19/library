<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $price = $this->faker->numberBetween(10, 1000); // Random price between 10 and 1000
        $cost = $this->faker->numberBetween(1, $price - 1); // Random cost between 1 and ($price - 1)

        return [
            'name' => fake()->randomElement(['قلم', "كشكول", "أستيكه", "كتاب", "مقلمة"]),
            'quantity' => fake()->numberBetween(1, 50),
            'price' => $price,
            'cost' => $cost,
        ];
    }
}
