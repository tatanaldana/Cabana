<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\VentaRequest;
use App\Http\Resources\VentaResource;
use App\Models\Venta;
use Illuminate\Http\Response;

class VentaController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:api');

        $this->middleware(['scope:admin','permission:view general'])->only('index');
        $this->middleware(['scope:admin','permission:view general'])->only(['ventaProceso', 'ventaCompletado']);
        $this->middleware(['scope:admin,cliente','permission:view general|ver personal cliente'])->only('show');
        $this->middleware(['scope:admin,cliente', 'permission:create general|registro parcial'])->only('store');
        $this->middleware(['scope:admin,cliente', 'permission:edit general|edicion parcial'])->only('update');
        $this->middleware(['scope:admin,cliente', 'permission:delete general|Eliminacion parcial'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $this->authorize('viewAny', Venta::class);
        $venta=Venta::included()->get();
        return VentaResource::collection($venta);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VentaRequest $request)
    {
        $this->authorize('create', Venta::class);
        $data = $request->validated();
        $venta = Venta::create([
            'metodo_pago' => $data['metodo_pago'],
            'estado' => "En Proceso",
            'total' => null, 
            'user_id' => $data['user_id'],
        ]);
        return response()->json([
            'message' => 'Venta creada exitosamente',
            'data' => new VentaResource($venta)
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        $this->authorize('view', $venta);

        $venta = Venta::included()->findOrFail($venta->id);

        return response()->json([
            'message' => 'Venta obtenida exitosamente',
            'data' =>new VentaResource($venta)
        ], Response::HTTP_OK);
        
    }

    public function ventaProceso(Venta $venta)
    {
        $this->authorize('viewVentas', $venta);

        $venta = Venta::where('estado', 0)->get();

        return response()->json([
            'message' => 'Venta obtenida exitosamente',
            'data' => VentaResource::collection($venta)
        ], Response::HTTP_OK);
        
    }

    public function ventaCompletado(Venta $venta)
    {
        $this->authorize('viewVentas', $venta);

        $venta = Venta::where('estado', 1)->get();

        return response()->json([
            'message' => 'Venta obtenida exitosamente',
            'data' =>VentaResource::collection($venta)
        ], Response::HTTP_OK);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VentaRequest $request,Venta $venta)
    {
        $this->authorize('update', $venta);
        $data = $request->validated();
        $venta->update($data);

        return response()->json([
            'message' => 'Venta actualizada exitosamente',
            'data' => new VentaResource($venta)
        ], Response::HTTP_OK);

    }

    public function destroy(Venta $venta){
        
        $this->authorize('delete', $venta);

        $venta->delete();

        return response()->json([
            'message' => 'Venta eliminada de manera exitosa'
        ], Response::HTTP_OK);
                   
    }
}
