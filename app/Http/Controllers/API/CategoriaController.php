<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;

class CategoriaController extends Controller
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
            $categorias = Categoria::included()->sort()->filter()->getOrPaginate();
            return CategoriaResource::collection($categorias);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Falla al obtener las categorias',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $categoria = Categoria::included()->findOrFail($id);
            return new CategoriaResource($categoria);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Falla al obtener la categoria',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request)
    {
        try {
            $this->authorize('create', Categoria::class);

            $data = $request->validated();
            $data['user_id'] = Auth::id(); // Obtener el ID del usuario autenticado

            $categoria = Categoria::create($data);

            return response()->json([
                'message' => 'Categoría creada exitosamente',
                'categoria' => new CategoriaResource($categoria)
            ], Response::HTTP_CREATED);
        } catch (AuthorizationException $e) {
            return response()->json([
                'error' => 'No tienes permiso para crear esta categoría.',
                'message' => $e->getMessage()
            ], Response::HTTP_FORBIDDEN);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al intentar crear la categoría',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        try {
            $this->authorize('update', $categoria);

            $data = $request->validated();
            $categoria->update($data);

            return response()->json([
                'message' => 'Categoria actualizada exitosamente',
                'categoria' => new CategoriaResource($categoria)
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar categoria',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        try {
            $this->authorize('delete', $categoria);

            $categoria->delete();

            return response()->json([
                'message' => 'Categoria eliminada de manera exitosa'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Falla al eliminar la categoría',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
