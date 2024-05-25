<?php

namespace Database\Seeders;

use App\Models\Detventa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetventaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detventa=New Detventa();
        $detventa->nom_producto='Hamburguesa de queso';
        $detventa->pre_producto='10000';
        $detventa->cantidad=1;
        $detventa->subtotal=10000;
        $detventa->venta_id='1';
        $detventa->save();

        $detventa1=New Detventa();
        $detventa1->nom_producto='Gaseosa Coca-Cola';
        $detventa1->pre_producto='10000';
        $detventa1->cantidad=1;
        $detventa1->subtotal=10000;
        $detventa1->venta_id='1';
        $detventa1->save();

        $detventa2=New Detventa();
        $detventa2->nom_producto='Salchipapa monster';
        $detventa2->pre_producto='20000';
        $detventa2->cantidad=1;
        $detventa2->subtotal=20000;
        $detventa2->venta_id='2';
        $detventa2->save();
        
        $detventa3=New Detventa();
        $detventa3->nom_producto='Jugo de limon';
        $detventa3->pre_producto='5000';
        $detventa3->cantidad=4;
        $detventa3->subtotal=20000;
        $detventa3->venta_id='2';
        $detventa3->save();

        $detventa4=New Detventa();
        $detventa4->nom_producto='Hamburguesa de pollo';
        $detventa4->pre_producto='12000';
        $detventa4->cantidad=2;
        $detventa4->subtotal=24000;
        $detventa4->venta_id='3';
        $detventa4->save();

        $detventa5=New Detventa();
        $detventa5->nom_producto='Salchipapa mini';
        $detventa5->pre_producto='12000';
        $detventa5->cantidad=2;
        $detventa5->subtotal=24000;
        $detventa5->venta_id='3';
        $detventa5->save();
    }
}
