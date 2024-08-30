<?php

namespace Database\Seeders;

use App\Models\Pqr;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PqrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pqr=New Pqr();
        $pqr->hechos='Comida exquisita';
        $pqr->pretensiones='No deberian cambiar jamas';
        $pqr->tipo_suge='Felicitacion';
        $pqr->estado='resuelta';
        $pqr->user_id=\App\Models\User::all()->random()->id;
        $pqr->save();

        $pqr1=New Pqr();
        $pqr1->hechos='Comida espantosa,me llego cruda.';
        $pqr1->pretensiones='Requiero una devolución de dinero';
        $pqr1->tipo_suge='Reclamacion';
        $pqr1->estado='En curso';
        $pqr1->user_id=\App\Models\User::all()->random()->id;
        $pqr1->save();

        $pqr2=New Pqr();
        $pqr2->hechos='Mal servicio, el camarero me trato con desprecio';
        $pqr2->pretensiones='Requiero una renuncia del camarero';
        $pqr2->tipo_suge='Quejas';
        $pqr2->estado='Radicada';
        $pqr2->user_id=\App\Models\User::all()->random()->id;
        $pqr2->save();

        
    }
}
