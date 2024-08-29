<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\RegistroRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RegistroController extends Controller
{
    public function store(RegistroRequest $request){
        $data=$request->validated();

        $data['password']=bcrypt($data['password']);

        $user=User::create($data);


        $clienteRole = Role::where('name', 'cliente')->first();
        $user->assignRole($clienteRole);

        return response()->json([
            'message' => 'Registro creado exitosamente'
        ], Response::HTTP_CREATED);
    }
}
