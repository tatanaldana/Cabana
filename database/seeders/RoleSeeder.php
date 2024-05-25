<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol= new Role();
        $rol->nombre='Administrador';
        $rol->save();

        $rol1= new Role();
        $rol1->nombre='Cliente';
        $rol1->save();
    }
}
