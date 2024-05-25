<?php

namespace Database\Seeders;

use App\Models\Proveedore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proovedor= new Proveedore();
        $proovedor->codigo='123456789';
        $proovedor->nombre='ALPINA';
        $proovedor->telefono='3216548970';
        $proovedor->direccion='CL 89 93 30';
        $proovedor->save();

        $proovedor1= new Proveedore();
        $proovedor1->codigo='93827156';
        $proovedor1->nombre='CARNES SAN RAFAEL';
        $proovedor1->telefono='6019866363';
        $proovedor1->direccion='CL 45 45 20';
        $proovedor1->save();

        $proovedor2= new Proveedore();
        $proovedor2->codigo='78451263';
        $proovedor2->nombre='BIMBO SAS';
        $proovedor2->telefono='6014402000';
        $proovedor2->direccion='KR 36 6 30';
        $proovedor2->save();

        $proovedor3= new Proveedore();
        $proovedor3->codigo='900630300';
        $proovedor3->nombre='SURTIFRUVER';
        $proovedor3->telefono='3502369584';
        $proovedor3->direccion='AV 45 100 20';
        $proovedor3->save();
    }
}
