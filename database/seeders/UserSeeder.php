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
        $usuario2= new User();
        $usuario2->doc='1014243818';
        $usuario2->nombre='Jhonatan';
        $usuario2->apellido='Aldana';
        $usuario2->tipo_doc='CC';
        $usuario2->clave='123456789*a';
        $usuario2->tel='3216549870';
        $usuario2->email='jbo@hotmail.com';
        $usuario2->fecha_naci='1993-10-21';
        $usuario2->genero='Hombre';
        $usuario2->direccion='KR 89 82 40';
        $usuario2->rol_id='1';
        $usuario2->save();

        $usuario= new User();
        $usuario->doc='123456789';
        $usuario->nombre='Daniel';
        $usuario->apellido='Gamboa';
        $usuario->tipo_doc='CC';
        $usuario->clave='123456789*b';
        $usuario->tel='3216549870';
        $usuario->email='daniel@gmail.com';
        $usuario->fecha_naci='1993-05-21';
        $usuario->genero='Hombre';
        $usuario->direccion='CL 76A 82 40';
        $usuario->rol_id='2';
        $usuario->save();

        $usuario1= new User();
        $usuario1->doc='1234567890';
        $usuario1->nombre='Luis';
        $usuario1->apellido='Cortes';
        $usuario1->tipo_doc='CC';
        $usuario1->clave='123456789*c';
        $usuario1->tel='3216549870';
        $usuario1->email='luis@gmail.com';
        $usuario1->fecha_naci='1983-10-21';
        $usuario1->genero='Hombre';
        $usuario1->direccion='KR 76A 82 40';
        $usuario1->rol_id='2';
        $usuario1->save();

        $usuario3= new User();
        $usuario3->doc='1594872630';
        $usuario3->nombre='Yonner';
        $usuario3->apellido='Vargar';
        $usuario3->tipo_doc='CC';
        $usuario3->clave='123456789*d';
        $usuario3->tel='3216549870';
        $usuario3->email='yonner@hotmail.com';
        $usuario3->fecha_naci='1996-11-01';
        $usuario3->genero='Hombre';
        $usuario3->direccion='KR 120SUR 82 40';
        $usuario3->rol_id='2';
        $usuario3->save();
    }
}
