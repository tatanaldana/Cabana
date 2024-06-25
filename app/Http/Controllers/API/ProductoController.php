<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware(['scope:admin', 'can:edit general'])->only('update');
        $this->middleware(['scope:admin', 'can:create general'])->only('store');
        $this->middleware(['scope:admin', 'can:delete general'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $productos = Producto::all();
            return response()->json($productos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Falla al obtener los productos',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {
        try {
            $this->authorize('create', Producto::class);

            $data = $request->validated();
            $data['categoria_id'] = $request->categorias_id;
            $producto = Producto::create($data);

            return response()->json([
                'message' => 'Producto creado exitosamente',
                'producto' => $producto
            ], Response::HTTP_CREATED);
        } catch (AuthorizationException $e) {
            return response()->json([
                'error' => 'No tienes permiso para crear este producto.',
                'message' => $e->getMessage()
            ], Response::HTTP_FORBIDDEN);
        } catch (\Exception $e) {
            return app(\App\Exceptions\Handler::class)->render(request(), $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            return response()->json($producto, 200);
        } catch (\Exception $e) {
            return app(\App\Exceptions\Handler::class)->render(request(), $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);

            $this->authorize('update', $producto);

            $data = $request->validated();
            $producto->update($data);

            return response()->json([
                'message' => 'Producto actualizado exitosamente',
                'producto' => $producto
            ], Response::HTTP_OK);
        } catch (AuthorizationException $e) {
            return response()->json([
                'error' => 'No tienes permiso para actualizar este producto.',
                'message' => $e->getMessage()
            ], Response::HTTP_FORBIDDEN);
        } catch (\Exception $e) {
            return app(\App\Exceptions\Handler::class)->render(request(), $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            $this->authorize('delete', $producto);

            $producto->delete();

            return response()->json(['message' => 'Producto eliminado exitosamente'], Response::HTTP_OK);
        } catch (AuthorizationException $e) {
            return response()->json([
                'error' => 'No tienes permiso para eliminar este producto.',
                'message' => $e->getMessage()
            ], Response::HTTP_FORBIDDEN);
        } catch (\Exception $e) {
            return app(\App\Exceptions\Handler::class)->render(request(), $e);
        }
    }
}

