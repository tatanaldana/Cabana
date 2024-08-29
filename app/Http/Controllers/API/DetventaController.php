<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DetventaRequest;
use App\Http\Resources\DetventaResource;
use App\Models\Detventa;
use App\Models\Venta;
use Illuminate\Http\Response;
use App\Traits\CalculoValores;


class DetventaController extends Controller
{
    use CalculoValores;
    
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scope:admin','permission:view general'])->only('index');
        $this->middleware(['scope:admin,cliente','permission:view general|ver personal cliente'])->only('show');
        $this->middleware(['scope:admin,cliente', 'permission:create general|registro parcial'])->only('store');
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
        $ventaId = $detalles[0]['venta_id'];
        $totalEnviado = $request->input('total');
    
        // Validar los detalles y el total
        $validationResult = $this->validarTotalYDetalles($detalles, $totalEnviado);
    
        if (!$validationResult['success']) {
            // Eliminar la venta si hay un error de validación
            Venta::where('id', $ventaId)->delete();
    
            return response()->json([
                'message' => $validationResult['message'],
                'total_calculado' => $validationResult['total_calculado'] ?? null,
            ], Response::HTTP_BAD_REQUEST);
        }
    
        // Registrar los detalles de la venta
        foreach ($detalles as $detalle) {
            Detventa::create([
                'nom_producto' => $detalle['nom_producto'],
                'pre_producto' => $detalle['pre_producto'],
                'cantidad' => $detalle['cantidad'],
                'subtotal' => $detalle['subtotal'],
                'venta_id' => $ventaId,
                'descuento' => $detalle['descuento'] ?? null,
                'porcentaje' => $detalle['porcentaje'] ?? null,
                'promocione_id' => $detalle['promocione_id'] ?? null,
            ]);
        }
    
        // Actualizar el total de la venta
        Venta::where('id', $ventaId)->update(['total' => $totalEnviado]);
    
        return response()->json([
            'message' => 'Detalles de la venta registrados exitosamente',
            'data' => Detventa::where('venta_id', $ventaId)->get(),
        ], Response::HTTP_CREATED);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

            $detventas = Detventa::included()->findOrFail($id);
    
            if ($detventas->isEmpty()) {
                abort(404, 'Detalle de venta no encontrado'); 
            }
    
            return DetventaResource::collection($detventas);
    }
}
