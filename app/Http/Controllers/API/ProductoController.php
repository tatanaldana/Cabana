<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\Response;


class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware(['scope:admin', 'permission:create general'])->only('store');
        $this->middleware(['scope:admin', 'permission:edit general'])->only('update');
        $this->middleware(['scope:admin', 'permission:delete general'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $productos = Producto::all();
            return ProductoResource::collection($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {
            $this->authorize('create', Producto::class);

            $data = $request->validated();
            $data['categoria_id'] = $request->categorias_id;
            $producto = Producto::create($data);

            return response()->json([
                'message' => 'Producto creado exitosamente',
                'data' => new ProductoResource($producto)
            ], Response::HTTP_CREATED);
 
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return response()->json([
            'message' => 'Productos obtenido exitosamente',
            'data' =>new ProductoResource($producto)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto)
    {

            $this->authorize('update', $producto);

            $data = $request->validated();
            $producto->update($data);

            return response()->json([
                'message' => 'Producto actualizado exitosamente',
                'producto' => new ProductoResource($producto)   
            ], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
            $this->authorize('delete', $producto);

            $producto->delete();

            return response()->json(['message' => 'Producto eliminado exitosamente'], Response::HTTP_OK);
    }
}

