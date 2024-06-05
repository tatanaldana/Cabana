<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DetpromocioneRequest;
use App\Http\Resources\DetpromocioneResource;
use App\Models\Detpromocione;
use Illuminate\Http\Response;

class DetpromocioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
        $this->middleware(['scopes:read-registros'])->only('index','show');
        $this->middleware(['scopes:update-registros','can:update general'])->only('update');
        $this->middleware(['scopes:create-registros','can:create general'])->only('store');
        $this->middleware(['scopes:delete-registros','can:delete general'])->only('destroy');
    }

    public function index()
    {
        try{
            $detpromocione=Detpromocione::included()->sort()->filter()->getOrPaginate()->groupBy('promocione_id');
            return DetpromocioneResource::collection($detpromocione);
        }catch(\Throwable $e){
            return response()->json([
                'message' => 'Falla al obtener detalle de promociones',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetpromocioneRequest $request)
    {
        try {
            $data = $request->validated();
            $user = auth()->user();
            $data['user_id'] = $user->id;

            if (!empty($data[0])) {
                $detpromociones = Detpromocione::createMany($data);
                 return response()->json([
                'message' => 'Registros creados exitosamente',
                'categoria' => new DetpromocioneResource($detpromociones)
            ], Response::HTTP_CREATED);
            } else {
                $detpromociones = Detpromocione::create($data);
                return response()->json([
                    'message' => 'Registro creado exitosamente',
                    'categoria' => new DetpromocioneResource($detpromociones)
                ], Response::HTTP_CREATED);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error al registrar el detalle de la promocion',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id){
        try{
            $detpromociones=Detpromocione::where('promocione_id', $id)->get();
     
            if ($detpromociones->isEmpty()) {
                return response()->json([
                    'message' => 'Detalle de promoción no encontrado'],
                     Response::HTTP_NOT_FOUND);
            }
            
            return response()->json($detpromociones, Response::HTTP_OK);

        }catch(\Throwable $e){
            return response()->json([
                'message' => 'Error al validar el detalle de la promocion',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
     
             return response()->json(['message' => 'Actualización exitosa', 'data' => $detpromociones], Response::HTTP_OK);
         } catch (\Throwable $th) {
             return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }

}
