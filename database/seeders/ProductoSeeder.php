<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $producto= new Producto();
        $producto->nom_producto='Hamburguesa de queso';
        $producto->precio_producto='10000';
        $producto->detalle='Hamburguesa doble carne con queso, tomate y lechuga';
        $producto->codigo='HQ1';
        $producto->categorias_id='1';
        $producto->save();

        $producto1= new Producto();
        $producto1->nom_producto='Hamburguesa de pollo';
        $producto1->precio_producto='12000';
        $producto1->detalle='Hamburguesa de pollo con queso, tomate y lechuga';
        $producto1->codigo='HP1';
        $producto1->categorias_id='1';
        $producto1->save();

        $producto2= new Producto();
        $producto2->nom_producto='Pizza mexicana';
        $producto2->precio_producto='8000';
        $producto2->detalle='Pizza mexicana picante, con todas las carnes';
        $producto2->codigo='PM1';
        $producto2->categorias_id='2';
        $producto2->save();

        $producto3= new Producto();
        $producto3->nom_producto='Pizza de champiñon';
        $producto3->precio_producto='8000';
        $producto3->detalle='Pizza de champiñon y queso';
        $producto3->codigo='PC1';
        $producto3->categorias_id='2';
        $producto3->save();

        $producto4= new Producto();
        $producto4->nom_producto='Salchipapa mini';
        $producto4->precio_producto='12000';
        $producto4->detalle='Salchipapa para dos personas';
        $producto4->codigo='SM1';
        $producto4->categorias_id='3';
        $producto4->save();

        $producto5= new Producto();
        $producto5->nom_producto='Salchipapa monster';
        $producto5->precio_producto='20000';
        $producto5->detalle='Salchipapa para cuatro personas';
        $producto5->codigo='SM2';
        $producto5->categorias_id='3';
        $producto5->save();

        $producto6= new Producto();
        $producto6->nom_producto='Jugo de limon';
        $producto6->precio_producto='5000';
        $producto6->detalle='Jugo de 300 ml de limon freco';
        $producto6->codigo='JL1';
        $producto6->categorias_id='4';
        $producto6->save();

        $producto7= new Producto();
        $producto7->nom_producto='Gaseosa Coca-Cola';
        $producto7->precio_producto='10000';
        $producto7->detalle='Gasesosa 3 litros Coca-cola';
        $producto7->codigo='GC1';
        $producto7->categorias_id='4';
        $producto7->save();
    }
}
