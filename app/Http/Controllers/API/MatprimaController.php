<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MatprimaRequest;
use App\Models\Matprima;
use Illuminate\Http\Request;

class MatprimaController extends Controller
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
            $data=Matprima::all();
            return response()->json($data,200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatprimaRequest $request)
    {
        try{
            $data['referencia']=$request['referencia'];
            $data['descripcion']=$request['descripcion'];
            $data['existencia']=$request['existencia'];
            $data['entrada']=$request['entrada'];
            $data['salida']=$request['salida'];
            $data['stock']=$request['stock'];
            $matprimas=Matprima::create($data);
            return response()->json(['message' => 'Registro creado exitosamente', 'data' => $matprimas], 201);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id){
        try{
            $matprimas=Matprima::find($id);
            if(!$matprimas) {
                return response()->json(['error' => 'Materia prima no encontrada'], 404);
            }
            return response()->json($matprimas, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatprimaRequest $request,$id)
    {
        try{
            $data['referencia']=$request['referencia'];
            $data['descripcion']=$request['descripcion'];
            $data['existencia']=$request['existencia'];
            $data['entrada']=$request['entrada'];
            $data['salida']=$request['salida'];
            $data['stock']=$request['stock'];
            $matprimas = Matprima::find($id);
            if(!$matprimas) {
                return response()->json(['error' => 'Materia prima no encontrada'], 404);
            }
            $matprimas->update($data);
            return response()->json(['message' => 'Actualización exitosa', 'data' => $matprimas], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try{
            $matprimas=Matprima::find($id);
            if(!$matprimas) {
                return response()->json(['error' => 'Materia prima no encontrada'], 404);
            }
            $matprimas->delete();
            return response()->json(['message' => 'Eliminación exitosa'], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
