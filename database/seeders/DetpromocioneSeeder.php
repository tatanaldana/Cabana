<?php

namespace Database\Seeders;

use App\Models\Detpromocione;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetpromocioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=2;
        $detpromocion->porcentaje=10;
        $detpromocion->descuento=2000;
        $detpromocion->subtotal=18000;
        $detpromocion->promocione_id='1';
        $detpromocion->producto_id='1';
        $detpromocion->save();

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=2;
        $detpromocion->porcentaje=10;
        $detpromocion->descuento=1000;
        $detpromocion->subtotal=9000;
        $detpromocion->promocione_id='1';
        $detpromocion->producto_id='7';
        $detpromocion->save();

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=3;
        $detpromocion->porcentaje=10;
        $detpromocion->descuento=2400;
        $detpromocion->subtotal=21600;
        $detpromocion->promocione_id='2';
        $detpromocion->producto_id='4';
        $detpromocion->save();

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=1;
        $detpromocion->porcentaje=10;
        $detpromocion->descuento=1000;
        $detpromocion->subtotal=9000;
        $detpromocion->promocione_id='2';
        $detpromocion->producto_id='8';
        $detpromocion->save();

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=3;
        $detpromocion->porcentaje=20;
        $detpromocion->descuento=4800;
        $detpromocion->subtotal=19200;
        $detpromocion->promocione_id='3';
        $detpromocion->producto_id='3';
        $detpromocion->save();

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=1;
        $detpromocion->porcentaje=18;
        $detpromocion->descuento=2160;
        $detpromocion->subtotal=9840;
        $detpromocion->promocione_id='3';
        $detpromocion->producto_id='5';
        $detpromocion->save();

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=2;
        $detpromocion->porcentaje=25;
        $detpromocion->descuento=6000;
        $detpromocion->subtotal=18000;
        $detpromocion->promocione_id='4';
        $detpromocion->producto_id='2';
        $detpromocion->save();

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=2;
        $detpromocion->porcentaje=25;
        $detpromocion->descuento=10000;
        $detpromocion->subtotal=30000;
        $detpromocion->promocione_id='4';
        $detpromocion->producto_id='6';
        $detpromocion->save();
    }
}
