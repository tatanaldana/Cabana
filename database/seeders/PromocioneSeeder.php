<?php

namespace Database\Seeders;

use App\Models\Promocione;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromocioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promocion=New Promocione();
        $promocion->nom_promo='San Valentin';
        $promocion->total_promo=27000;
        $promocion->categorias_id='5';
        $promocion->save();

        $promocion1=New Promocione();
        $promocion1->nom_promo='San Pedro';
        $promocion1->total_promo=30600;
        $promocion1->categorias_id='5';
        $promocion1->save();

        $promocion2=New Promocione();
        $promocion2->nom_promo='Navidad';
        $promocion2->total_promo=30000;
        $promocion2->categorias_id='5';
        $promocion2->save();

        $promocion3=New Promocione();
        $promocion3->nom_promo='Año Nuevo';
        $promocion3->total_promo=35000;
        $promocion3->categorias_id='5';
        $promocion3->save();

    }
}
