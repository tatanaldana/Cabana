<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedore>
 */
class ProveedoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo'=>$this->faker->unique()->randomNumber(9, true),
            'nombre'=>$this->faker->firstName(),
            'telefono'=>$this->faker->randomNumber(9, true),
            'direccion'=>$this->faker->unique()->streetAddress()
        ];
    }
}
