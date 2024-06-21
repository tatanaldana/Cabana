<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scopes:read-registros'])->only('index','show');
        $this->middleware(['scopes:update-registros','can:update general'])->only('update');
        $this->middleware(['scopes:create-registros','can:create general'])->only('store');
        $this->middleware(['scopes:delete-registros','can:delete general'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data=User::all();
            return response()->json($data,200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    public function store(UserRequest $request){
        $data=$request->validated();
        $user=User::create($data);
        /*return UserResource::make($categoria);*/
        return $user;

    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $users=User::included()->find($id);
            if(!$users || !$users->exists()) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            return response()->json($users, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request,$id)
    {
        try{
            $this->authorize('update', User::class);
            $data['tel']=$request['tel'];
            $data['genero']=$request['genero'];
            $data['direccion']=$request['direccion'];
            $users = User::find($id);
            if(!$users || !$users->exists()) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            $users->update($data);
            return response()->json(['message' => 'Actualización exitosa', 'data' => $users], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try{
            $users=User::find($id);
            if(!$users || !$users->exists()) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            $users->delete();
            return response()->json(['message' => 'Eliminación exitosa'], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
