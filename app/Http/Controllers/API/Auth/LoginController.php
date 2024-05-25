<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function store(LoginRequest $request){
       
        $request->validated();

        $user = User::where('email', $request->email)->firstOrFail();

        if(Hash::check($request->password,$user->password)){
            return UserResource::make($user);
        }else{
            return response()->json(['message'=>'These credentials do not match our records',404]);
        }

    }

}
