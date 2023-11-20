<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_model_id' => 1,
            'name' => fake()->word(),
            'year' => fake()->year(),
            'consumption' => fake()->randomFloat(),
            'horsepower' => fake()->randomNumber(),
            'car_class_id' => 1,
            'salon_id' => 1,
        ];
    }
}
