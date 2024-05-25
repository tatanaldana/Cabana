<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promocione>
 */
class PromocioneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_promo'=>fake()->unique()->word(),
            'total_promo'=>fake()->randomNumber(5, true),
            'categoria_id'=>\App\Models\Categoria::all()->random()->id
        ];
    }
}
