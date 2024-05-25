<?php

namespace Database\Seeders;

use App\Models\Venta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venta=New Venta();
        $venta->metodo_pago='Efectivo';
        $venta->estado=true;
        $venta->total=20000;
        $venta->usuarios_doc='1594872630';
        $venta->save();

        $venta1=New Venta();
        $venta1->metodo_pago='Tarjeta debito';
        $venta1->estado=true;
        $venta1->total=40000;
        $venta1->usuarios_doc='1234567890';
        $venta1->save();

        $venta2=New Venta();
        $venta2->metodo_pago='Nequi';
        $venta2->estado=false;
        $venta2->total=48000;
        $venta2->usuarios_doc='123456789';
        $venta2->save();
    }
}
