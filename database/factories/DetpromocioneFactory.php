<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detpromocione>
 */
class DetpromocioneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cantidad'=>fake()->randomNumber(5, true),
            'descuento'=>fake()->randomNumber(5, true),
            'subtotal'=>fake()->randomNumber(5, true),
            'producto_id'=>\App\Models\Producto::all()->random()->id,
            'promocione_id'=>\App\Models\Promocione::all()->random()->id,
        ];
    }
}
