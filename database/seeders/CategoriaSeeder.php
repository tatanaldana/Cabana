<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Image;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Hamburguesas',
            'Pizzas',
            'Salchipapa',
            'Bebidas',
            'Promociones'
        ];

        foreach ($categorias as $nombre) {
            $categoria = new Categoria();
            $categoria->nombre_cat = $nombre;
            $categoria->save();

        }
    }
}

