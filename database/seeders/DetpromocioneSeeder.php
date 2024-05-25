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
        $detpromocion->descuento=2000;
        $detpromocion->subtotal=18000;
        $detpromocion->promocione_id='1';
        $detpromocion->producto_id='1';

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=2;
        $detpromocion->descuento=1000;
        $detpromocion->subtotal=9000;
        $detpromocion->promocione_id='1';
        $detpromocion->producto_id='7';

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=3;
        $detpromocion->descuento=2400;
        $detpromocion->subtotal=21600;
        $detpromocion->promocione_id='2';
        $detpromocion->producto_id='4';

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=1;
        $detpromocion->descuento=1000;
        $detpromocion->subtotal=9000;
        $detpromocion->promocione_id='2';
        $detpromocion->producto_id='8';

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=3;
        $detpromocion->descuento=4000;
        $detpromocion->subtotal=20000;
        $detpromocion->promocione_id='3';
        $detpromocion->producto_id='3';

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=1;
        $detpromocion->descuento=2000;
        $detpromocion->subtotal=10000;
        $detpromocion->promocione_id='3';
        $detpromocion->producto_id='5';

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=2;
        $detpromocion->descuento=4000;
        $detpromocion->subtotal=20000;
        $detpromocion->promociones_id='4';
        $detpromocion->productos_id='2';

        $detpromocion=New Detpromocione();
        $detpromocion->cantidad=2;
        $detpromocion->descuento=5000;
        $detpromocion->subtotal=15000;
        $detpromocion->promociones_id='4';
        $detpromocion->productos_id='6';
    }
}
