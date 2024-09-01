<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        {
            User::create([
                'id'=>'1014243818',
                'name' => 'Jhonatan Aldana Rodriguez',
                'email' => 'jbojhonatan@gmail.com',
                'password' => bcrypt('12345678*a'),
                'tipo_doc'=>'CC',
                'tel'=>'3202659832',
                'fecha_naci'=>'1993-05-23',
                'genero'=>'Masculino',
                'direccion'=>'CL 76A 82 40',
                'email_verified_at'=>now()

            ])->assignRole('admin');
    
    
            $users=User::factory(99)->create();
            foreach ($users as $user) {
                $user->assignRole('cliente');
            }
        }
    }

}
