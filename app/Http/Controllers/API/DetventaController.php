<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DetventaRequest;
use App\Http\Resources\DetventaResource;
use App\Models\Detventa;
use Illuminate\Http\Response;


class DetventaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['scope:admin', 'can:view general'])->only('index', 'show');
        $this->middleware(['scope:cliente', 'can:ver personal cliente'])->only('show');
        $this->middleware(['scope:admin', 'can:create general'])->only('store');
        $this->middleware(['scope:cliente', 'can:registro parcial'])->only('store');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $this->authorize('viewAny', Detventa::class);

            $detventas = Detventa::all();
            return DetventaResource::collection($detventas);       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetventaRequest $request)
    {
        $this->authorize('create', Detventa::class);

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
    
            $detventas[] = new DetventaResource($detventa);
        }
    
        return response()->json([
            'message' => 'Registros creados exitosamente',
            'data' => $detventas,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

            $detventas = Detventa::included()->where('venta_id', $id)->get();
    
            if ($detventas->isEmpty()) {
                abort(404, 'Detalle de venta no encontrado'); 
            }
    
            return DetventaResource::collection($detventas);
    }
}
