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
       /* $this->middleware('auth:api')->except(['index','show']);
        /*
        $this->middleware(['scope:admin','can:edit general'])->only('update');
        $this->middleware(['scope:admin','can:create general'])->only('store');
        $this->middleware(['scope:admin','can:delete general'])->only('destroy');
        */
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categoria = Categoria::included()->sort()->filter()->getOrPaginate();
            return CategoriaResource::collection($categoria);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Falla al obtener las categorias',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id){
        try{
            $categoria=Categoria::included()->where('id', $id)->get();
            if(!$categoria) {
                return response()->json(['error' => 'Detalle de promocion no encontrado'], 404);
            }
            return response()->json($categoria, 200);
        }catch(\Throwable $th){
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function store(CategoriaRequest $request)
    {
        try {
            $this->authorize('create', Categoria::class);
            $data = $request->validated();
            $user = auth()->user();
            $data['user_id'] = $user->id;

            $categoria = Categoria::create($data);

            return response()->json([
                'message' => 'Categoria created successfully',
                'categoria' => new CategoriaResource($categoria)
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create categoria',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

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

    public function destroy(Categoria $categoria)
    {
        try {
            $this->authorize('delete', $categoria);
            $categoria->delete();

            return response()->json([
                'message' => 'Categoria eliminada de manera exitosa'
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete categoria',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

