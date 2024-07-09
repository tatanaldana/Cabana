<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DetventaRequest;
use App\Http\Resources\DetventaResource;
use App\Models\Detventa;


class DetventaController extends Controller
{/*
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scopes:read-registros'])->only('index','show');
        $this->middleware(['scopes:create-registros','can:create general'])->only('store');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $detventas = Detventa::included()->sort()->filter()->getOrPaginate();
            return DetventaResource::collection($detventas);
            
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetventaRequest $request)
    {
        try {
            $detalles = $request->validated()['detalles'];
            $detventas = [];

                foreach ($detalles as $detalle) {
                    $detventa = Detventa::create([
                        'nom_producto' => $detalle['nom_producto'],
                        'pre_producto' => $detalle['pre_producto'],
                        'cantidad' => $detalle['cantidad'],
                        'subtotal' => $detalle['subtotal'],
                        'venta_id' => $detalle['venta_id'],
                    ]);

                    $detventas[] = $detventa; // Opcional: Guardar cada instancia en un arreglo para respuesta posterior
            }

            return response()->json(['message' => 'Registros creados exitosamente', 'data' => $detventas], 201);
            // Si estás utilizando recursos, puedes retornar el recurso de Detventa
            // return DetventaResource::collection($detventas);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $detventas = Detventa::included()->where('venta_id', $id)->get();

            $detventasGrouped = $detventas->groupBy('venta_id');
    
            return response()->json( $detventasGrouped, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
