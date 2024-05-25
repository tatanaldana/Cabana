<?php

namespace Database\Seeders;

use App\Models\Matprima;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatprimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matprima= new Matprima();
        $matprima->referencia='Queso Alpina';
        $matprima->descripcion='Bloque de queso descremado de 4KG';
        $matprima->existencia=10;
        $matprima->entrada=1;
        $matprima->salida=4;
        $matprima->stock=7;
        $matprima->save();

        $matprima1= new Matprima();
        $matprima1->referencia='Carne de hamburguesa';
        $matprima1->descripcion='Paquete de carne de hamburguesa ANGUS de 20 unidades';
        $matprima1->existencia=10;
        $matprima1->entrada=1;
        $matprima1->salida=4;
        $matprima1->stock=7;
        $matprima1->save();

        $matprima2= new Matprima();
        $matprima2->referencia='Pollo';
        $matprima2->descripcion='Pollo para preparar de 1 KG';
        $matprima2->existencia=10;
        $matprima2->entrada=1;
        $matprima2->salida=4;
        $matprima2->stock=7;
        $matprima2->save();

        $matprima3= new Matprima();
        $matprima3->referencia='Pan para hamburguesa';
        $matprima3->descripcion='Paquete de pan para hamburguesa CRIOLLO de 20 unidades';
        $matprima3->existencia=10;
        $matprima3->entrada=1;
        $matprima3->salida=4;
        $matprima3->stock=7;
        $matprima3->save();
    }
}
