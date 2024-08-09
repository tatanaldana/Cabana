<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\Response;


class CategoriaController extends Controller
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
        $categorias = Categoria::included()->get();
        return CategoriaResource::collection($categorias);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        $categoria = Categoria::included()->findOrFail($categoria->id);

        return response()->json([
            'message' => 'cataegoria obtenida exitosamente',
            'data' =>new CategoriaResource($categoria)
        ], Response::HTTP_OK);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request)
    {
        $this->authorize('create', Categoria::class);

        $data = $request->validated();
        $categoria = Categoria::create($data);

        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'data' => new CategoriaResource($categoria)
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $this->authorize('update', $categoria);

        $data = $request->validated();
        $categoria->update($data);

        return response()->json([
            'message' => 'Categoría actualizada exitosamente',
            'data' => new CategoriaResource($categoria)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $this->authorize('delete', $categoria);

        $categoria->delete();

        return response()->json([
            'message' => 'Categoría eliminada de manera exitosa'
        ], Response::HTTP_OK);
    }
}