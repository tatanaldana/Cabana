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
            $this->middleware(['scope:admin', 'can:view general'])->only('index', 'show');
            $this->middleware(['scope:admin', 'can:edit general'])->only('update');
            $this->middleware(['scope:admin', 'can:create general'])->only('store');
            $this->middleware(['scope:admin', 'can:delete general'])->only('destroy');
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
    public function show($id)
    {
        $matprima = Matprima::findOrFail($id);
        $this->authorize('view', $matprima);

        return new MatprimaResource($matprima);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatprimaRequest $request, $id)
    {
        $matprima = Matprima::findOrFail($id);
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
    public function destroy($id)
    {
        $matprima = Matprima::findOrFail($id);
        $this->authorize('delete', $matprima);

        $matprima->delete();
        return response()->json(
            ['message' => 'Eliminación exitosa'], Response::HTTP_OK);
    }
}

