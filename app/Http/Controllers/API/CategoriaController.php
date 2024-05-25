<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;


class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
       // $this->middleware('scopes:read-categoria')->only('index','show');
        //$this->middleware('scopes:create-categoria')->only('store');
        //$this->middleware('scopes:delete-categoria')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = Categoria::included()->sort()->filter()->getOrPaginate();
        return CategoriaResource::collection($categoria);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(CategoriaRequest $request)
    {
        $data=$request->validated();
        $user=auth()->user();
        $data['user_id']=$user->id;
        $categoria=Categoria::create($data);
        return CategoriaResource::make($categoria);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoria=Categoria::included()->findOrFail($id);
        return CategoriaResource::make($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $data = $request->validated();
        $categoria->update($data);
        return CategoriaResource::make($categoria);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return CategoriaResource::make($categoria);
    }
}
