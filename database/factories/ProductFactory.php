<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
    public function definition()
    {
        $name = fake()->sentence(6);
        return [
            'name' => $name,
            'slug' => Str::slug($name, "-"),
            'description' => fake()->paragraph(),
            'price' => fake()->randomNumber(2)
        ];
    }
}
