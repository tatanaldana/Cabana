<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'metodo_pago'=>fake()->creditCardType(),
            'estado'=>fake()->boolean(),
            'total'=>fake()->randomNumber(5, true),
            'user_id'=>\App\Models\User::all()->random()->id
        ];
    }
}
