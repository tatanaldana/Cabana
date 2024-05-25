<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data=Role::all();
            return response()->json($data,200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        try{
            $data['nombre']=$request['nombre'];
            $roles=Role::create($data);
            return response()->json(['message' => 'Registro creado exitosamente', 'data' => $roles], 201);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $roles=Role::included()->find($id);
            if(!$roles || !$roles->exists()) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }
            return response()->json($roles, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request,$id)
    {
        try{
            $data['nombre']=$request['nombre'];
            $roles = Role::find($id);
            if(!$roles || !$roles->exists()) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }
            $roles->update($data);
            return response()->json(['message' => 'Actualización exitosa', 'data' => $roles], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try{
            $roles=Role::find($id);
            if(!$roles || !$roles->exists()) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }
            $roles->delete();
            return response()->json(['message' => 'Eliminación exitosa'], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
