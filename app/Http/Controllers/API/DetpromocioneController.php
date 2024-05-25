<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DetpromocioneRequest;
use App\Models\Detpromocione;
use Illuminate\Http\Request;

class DetpromocioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data=Detpromocione::all()->groupBy('promocione_id');
            return response()->json(['message' => 'Promciones encontradas', 'data' => $data],200);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetpromocioneRequest $request)
    {
        try {
            $data = $request->all();
            if (!empty($data[0])) {
                $detpromociones = Detpromocione::createMany($data);
                return response()->json(['message' => 'Registros creados exitosamente', 'data' => $detpromociones], 201);
            } else {
                $detpromociones = Detpromocione::create($data);
                return response()->json(['message' => 'Registro creado exitosamente', 'data' => $detpromociones], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id){
        try{
            $detpromociones=Detpromocione::where('promocione_id', $id)->get();
            if(!$detpromociones) {
                return response()->json(['error' => 'Detalle de promocion no encontrado'], 404);
            }
            return response()->json($detpromociones, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DetpromocioneRequest $request, $id)
    {
        try {
            $data = $request->all();
            $existingRecords = Detpromocione::where('promocione_id', $id)->get();

            $detpromociones = [];
            foreach ($existingRecords as $existingRecord) {
                $registro = collect($data)->where('id', $existingRecord->id)->first();
                if ($registro) {
                    $existingRecord->update([
                        'cantidad' => $registro['cantidad'],
                        'descuento' => $registro['descuento'],
                        'subtotal' => $registro['subtotal'],
                        'producto_id' => $registro['producto_id'],
                    ]);
                    $detpromociones[] = $existingRecord;
                } else {
                    $existingRecord->delete();
                }
            }
    
            foreach ($data as $registro) {
                $existingRecord = $existingRecords->where('id', $registro['id'])->first();
                if (!$existingRecord) {
                    $detpromocion = Detpromocione::create([
                        'cantidad' => $registro['cantidad'],
                        'descuento' => $registro['descuento'],
                        'subtotal' => $registro['subtotal'],
                        'promocione_id' => $id,
                        'producto_id' => $registro['producto_id'],
                    ]);
                    $detpromociones[] = $detpromocion;
                }
            }
    
            return response()->json(['message' => 'Actualización exitosa', 'data' => $detpromociones], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

}
