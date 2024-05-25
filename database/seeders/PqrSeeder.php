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
        $pqr->sugerencia='Comida exquisita, no deberian cambiar jamas';
        $pqr->tipo_suge='Felicitacion';
        $pqr->estado='resuelta';
        $pqr->user_id='123456789';
        $pqr->save();

        $pqr1=New Pqr();
        $pqr1->sugerencia='Comida espantosa,me llego cruda.Requiero una devolución de dinero';
        $pqr1->tipo_suge='Reclamo';
        $pqr1->estado='En curso';
        $pqr1->user_id='1234567890';
        $pqr1->save();

        $pqr2=New Pqr();
        $pqr2->sugerencia='Mal servicio, el camarero me trato con desprecio';
        $pqr2->tipo_suge='Queja';
        $pqr2->estado='Radicada';
        $pqr2->user_id='1594872630';
        $pqr2->save();

        
    }
}
