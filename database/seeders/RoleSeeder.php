<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $cliente = Role::create(['name' => 'cliente']);

        
        $viewGeneral = Permission::create(['name' => 'view general']);
        $createGeneral = Permission::create(['name' => 'create general']);
        $editGeneral = Permission::create(['name' => 'edit general']);
        $deleteGeneral = Permission::create(['name' => 'delete general']);

        $viewCliente = Permission::create(['name' => 'ver personal cliente']);
        $createCliente = Permission::create(['name' => 'registro parcial']);
        $editCliente = Permission::create(['name' => 'edicion parcial']);
        $deleteCliente = Permission::create(['name' => 'Eliminacion parcial']);


        $admin->syncPermissions([$createGeneral,$editGeneral,$deleteGeneral,$viewGeneral]);
        $cliente->syncPermissions([$createCliente,$editCliente,$deleteCliente,$viewCliente]);


    }
}
