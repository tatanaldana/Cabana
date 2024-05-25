<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detventa>
 */
class DetventaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_producto'=>fake()->unique()->word(),
            'pre_producto'=>fake()->randomNumber(5, true),
            'subtotal'=>fake()->randomNumber(5, true),
            'cantidad'=>fake()->randomNumber(5, true),
            'venta_id'=>\App\Models\Venta::all()->random()->id,
        ];
    }
}
