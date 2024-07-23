<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PqrRequest;
use App\Models\Pqr;
use Illuminate\Http\Request;

class PqrController extends Controller
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
            $data=Pqr::all();
            return response()->json($data,200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PqrRequest $request)
    {
        try{
            $data['sugerencia']=$request['sugerencia'];
            $data['tipo_suge']=$request['tipo_suge'];
            $data['estado']=$request['estado'];
            $data['user_id']=$request['user_id'];
            $pqrs=Pqr::create($data);
            return response()->json(['message' => 'Registro creado exitosamente', 'data' => $pqrs], 201);
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
            $pqrs=Pqr::included()->find($id);
            if(!$pqrs) {
                return response()->json(['error' => 'Pqrs no encontrados'], 404);
            }
            return response()->json($pqrs, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(PqrRequest $request,$id){
        try{
            $data['estado']=$request['estado'];
            $pqrs = Pqr::find($id);
            if(!$pqrs) {
                return response()->json(['error' => 'Pqrs no encontrados'], 404);
            }
            $pqrs->update($data);
            return response()->json(['message' => 'Actualización exitosa', 'data' => $pqrs], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try{
            $pqrs=Pqr::find($id);
            if(!$pqrs) {
                return response()->json(['error' => 'Pqrs no encontrados'], 404);
            }
            $pqrs->delete();
            return response()->json(['message' => 'Eliminación exitosa'], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
