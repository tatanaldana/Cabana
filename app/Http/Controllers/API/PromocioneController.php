<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PromocioneRequest;
use App\Models\Promocione;
use Illuminate\Http\Request;

class PromocioneController extends Controller
{
/*
    public function __construct()
    {/*
        $this->middleware('auth:api')->except(['index','show']);
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
            $data=Promocione::all();
            return response()->json($data,200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromocioneRequest $request)
    {
        try{
            $data = $request->validated();
            $promociones=Promocione::create($data);
            return response()->json(['message' => 'Registro creado exitosamente', 'data' => $promociones], 201);
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
            $promociones=Promocione::included()->find($id);
            if(!$promociones) {
                return response()->json(['error' => 'Promocion no encontrada'], 404);
            }
            return response()->json($promociones, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromocioneRequest $request,$id)
    {
        try{
            $data['nom_promo']=$request['nom_promo'];
            $data['total_promo']=$request['total_promo'];
            $promociones = Promocione::find($id);
            if(!$promociones) {
                return response()->json(['error' => 'Promocion no encontrada'], 404);
            }
            $promociones->update($data);
            return response()->json(['message' => 'Actualización exitosa', 'data' => $promociones], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try{
            $promociones=Promocione::find($id);
            if(!$promociones) {
                return response()->json(['error' => 'Promocion no encontrada'], 404);
            }
            $promociones->delete();
            return response()->json(['message' => 'Eliminación exitosa'], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
