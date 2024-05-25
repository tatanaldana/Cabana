<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matprima>
 */
class MatprimaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'referencia'=>$this->faker->text(15),
            'descripcion'=>$this->faker->text(200),
            'existencia'=>$this->faker->randomNumber(3, true),
            'entrada'=>$this->faker->randomNumber(3, false),
            'salida'=>$this->faker->randomNumber(3, false),
            'stock'=>$this->faker->randomNumber(3, false)
        ];
    }
}
