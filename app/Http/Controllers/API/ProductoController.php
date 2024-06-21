<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{/*
    public function __construct()
    {
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
            $data=Producto::all();
            return response()->json($data,200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {
        try{
            $data['nom_producto']=$request['nom_producto'];
            $data['precio_producto']=$request['precio_producto'];
            $data['detalle']=$request['detalle'];
            $data['codigo']=$request['codigo'];
            $data['categorias_id']=$request['categorias_id'];
            $productos=Producto::create($data);
            return response()->json(['message' => 'Registro creado exitosamente', 'data' => $productos], 201);
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
            $productos=Producto::included()->find($id);
            if(!$productos) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            return response()->json($productos, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, $id){
        try{
            $data['nom_producto']=$request['nom_producto'];
            $data['precio_producto']=$request['precio_producto'];
            $data['detalle']=$request['detalle'];
            $data['codigo']=$request['codigo'];
            $productos = Producto::find($id);
            if(!$productos) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            $productos->update($data);
            return response()->json(['message' => 'Actualización exitosa', 'data' => $productos], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function destroy($id){
        try{
            $productos=Producto::find($id);
            if(!$productos) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            $productos->delete();
            return response()->json(['message' => 'Eliminación exitosa'], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}
