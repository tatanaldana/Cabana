<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\RegistroRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegistroController extends Controller
{
    public function store(RegistroRequest $request){
        $data=$request->validated();

        $data['password']=bcrypt($data['password']);

        $user=User::create($data);

        return UserResource::make($user);
    }
}
