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
        $this->middleware(['scope:admin', 'permission:create general'])->only('store');
        $this->middleware(['scope:admin', 'permission:edit general'])->only('update');

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detpromociones = Detpromocione::included()->get();
        return DetpromocioneResource::collection($detpromociones);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detpromociones = Detpromocione::included()->findOrFail($id);
        
        return DetpromocioneResource::collection($detpromociones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetpromocioneRequest $request)
    {
        $this->authorize('create', Detpromocione::class);

        $data = $request->validated()['detalles'];
        $detpromociones = [];

        foreach ($data as $detalle) {
            $detpromocione = Detpromocione::create([
                'cantidad' => $detalle['cantidad'],
                'descuento' => $detalle['descuento'],
                'subtotal' => $detalle['subtotal'],
                'promocione_id' => $detalle['promocione_id'],
                'producto_id' => $detalle['producto_id'],
            ]);
            $detpromociones[] = new DetpromocioneResource($detpromocione);
        }

        return response()->json([
            'message' => 'Registros creados exitosamente',
            'data' =>$detpromociones,
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DetpromocioneRequest $request, $id)
    {
        $this->authorize('update', Detpromocione::class);

        $data = $request->all();
        $dataDetalles=$data['detalles'];
        $existingRecords = Detpromocione::where('promocione_id', $id)->get();
        $detpromociones = [];

        foreach ($existingRecords as $existingRecord) {
            $registro = collect($dataDetalles)->where('id', $existingRecord->id)->first();
            if ($registro) {
                $existingRecord->update([
                    'id'=> $registro['id'],
                    'cantidad' => $registro['cantidad'],
                    'descuento' => $registro['descuento'],
                    'subtotal' => $registro['subtotal'],
                    'producto_id' => $registro['producto_id'],
                ]);
               $detpromociones[] = new DetpromocioneResource($existingRecord);
            } else {
                $existingRecord->delete();
            }
        }


        foreach ($dataDetalles as $registro) {
            $existingRecord = $existingRecords->where('id', $registro['id'])->first();
            if (!$existingRecord) {
                $detpromocion = Detpromocione::create([
                    'cantidad' => $registro['cantidad'],
                    'descuento' => $registro['descuento'],
                    'subtotal' => $registro['subtotal'],
                    'promocione_id' => $id,
                    'producto_id' => $registro['producto_id'],
                ]);
                $detpromociones[] = new DetpromocioneResource($detpromocion);
            }
        }

        return response()->json([
            'message' => 'Actualización exitosa',
            'data' =>$detpromociones,
        ], Response::HTTP_OK);
    }

}
