<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pqr>
 */
class PqrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sugerencia'=>fake()->text(200),
            'tipo_suge'=>fake()->randomElement(['queja', 'reclamo','sugerencia','peticion']),
            'estado'=>fake()->randomElement(['registrada', 'en curso','resuelta']),
            'user_id'=>\App\Models\User::pluck('id')->random()
        ];
    }
}
