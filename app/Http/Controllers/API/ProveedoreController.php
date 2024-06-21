<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProveedoreRequest;
use App\Models\Proveedore;
use Illuminate\Http\Request;

class ProveedoreController extends Controller
{/*
    public function __construct()
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
            $data=Proveedore::all();
            return response()->json($data,200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProveedoreRequest $request)
    {
        try{
            $data['codigo']=$request['codigo'];
            $data['nombre']=$request['nombre'];
            $data['telefono']=$request['telefono'];
            $data['direccion']=$request['direccion'];
            $proveedores=Proveedore::create($data);
            return response()->json(['message' => 'Registro creado exitosamente', 'data' => $proveedores], 201);
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
            $proveedores=Proveedore::find($id);
            if(!$proveedores) {
                return response()->json(['error' => 'Proveedores no encontrados'], 404);
            }
            return response()->json($proveedores, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProveedoreRequest $request,$id)
    {
        try{
            $data['codigo']=$request['codigo'];
            $data['nombre']=$request['nombre'];
            $data['telefono']=$request['telefono'];
            $data['direccion']=$request['direccion'];
            $proveedores = Proveedore::find($id);
            if(!$proveedores) {
                return response()->json(['error' => 'Proveedores no encontrados'], 404);
            }
            $proveedores->update($data);
            return response()->json(['message' => 'Actualización exitosa', 'data' => $proveedores], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try{
            $proveedores=Proveedore::find($id);
            if(!$proveedores) {
                return response()->json(['error' => 'Proveedores no encontrados'], 404);
            }
            $proveedores->delete();
            return response()->json(['message' => 'Eliminación exitosa'], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
