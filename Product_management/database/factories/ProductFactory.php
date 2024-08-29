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
        return [
            'image' => 'image|max:2048',
            'product_name' => $this->faker->realText(30),
            'price' => $this->faker->numberBetween($min = 50, $max = 9999),
            'stock' => $this->faker->numberBetween($min = 0, $max = 9999),
            'maker' => $this->faker->realText(30),
            'detail' => '詳細',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];
    }
}
