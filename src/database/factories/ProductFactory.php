<?php

namespace Database\Factories;

use App\Models\Category;
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
        return [
            'name' => fake()->regexify('[a-z]{10}'),
            'code' => fake()->unique()->regexify('[a-z_\-]{10}'),
            'category_id' => Category::factory(),
            'price'  => fake()->numberBetween(1, 1000),
            'release_date' => fake()->dateTime,
        ];
    }
}
