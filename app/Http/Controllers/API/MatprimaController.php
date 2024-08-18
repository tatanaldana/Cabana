<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MatprimaRequest;
use App\Http\Resources\MatprimaResource;
use App\Models\Matprima;
use Illuminate\Http\Response;

class MatprimaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scope:admin','permission:view general'])->only('index');
        $this->middleware(['scope:admin','permission:view general'])->only('show');
        $this->middleware(['scope:admin', 'permission:create general'])->only('store');
        $this->middleware(['scope:admin','permission:edit general}'])->only('update');
        $this->middleware(['scope:admin', 'permission:delete general'])->only('destroy');

    }
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Matprima::class);

        $matprimas = Matprima::all();
        return MatprimaResource::collection($matprimas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatprimaRequest $request)
    {
        $this->authorize('create', Matprima::class);

        $data = $request->validated();
        $matprima = Matprima::create($data);

        return response()->json(
            ['message' => 'Registro creado exitosamente', 
            'data' => new MatprimaResource($matprima)]
            ,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Matprima $matprima)
    {    
        $this->authorize('view', $matprima);
        
        return response()->json([
            'message' => 'Materia prima obtenida exitosamente',
            'data' =>new MatprimaResource($matprima)
        ], Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatprimaRequest $request, Matprima $matprima)
    {
        $this->authorize('update', $matprima);

        $data = $request->validated();
        $matprima->update($data);

        return response()->json(
            ['message' => 'Actualización exitosa', 
            'data' => new MatprimaResource($matprima)], 
            Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matprima $matprima)
    {
        $this->authorize('delete', $matprima);

        $matprima->delete();
        return response()->json(
            ['message' => 'Eliminación exitosa'], Response::HTTP_OK);
    }
}

