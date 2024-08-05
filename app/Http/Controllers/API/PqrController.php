<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PqrRequest;
use App\Http\Resources\PqrResource;
use App\Models\Pqr;
use Illuminate\Http\Response;


class PqrController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scope:admin','permission:view general'])->only('index');
        $this->middleware(['scope:admin,cliente','permission:view general|ver personal cliente'])->only('show');
        $this->middleware(['scope:cliente', 'permission:registro parcial'])->only('store');
        $this->middleware(['scope:admin', 'permission:edit general'])->only('update');
        $this->middleware(['scope:admin', 'permission:delete general'])->only('destroy');
    }
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Pqr::class);

        $pqr = Pqr::all();
        return PqrResource::collection($pqr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PqrRequest $request)
    {
        $this->authorize('create', Pqr::class);

        $data = $request->validated();
        $pqr = Pqr::create($data);

        return response()->json(
            ['message' => 'Registro creado exitosamente', 
            'data' => new PqrResource($pqr)],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Pqr $pqr)
    {
        $this->authorize('view', $pqr);

        return response()->json([
            'message' => 'Pqrs obtenidas exitosamente',
            'data' =>new PqrResource($pqr)
        ], Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PqrRequest $request, Pqr $pqr)
    {
        
        $this->authorize('update', $pqr);

        $data = $request->validated();

        $pqr->update($data);

        return response()->json(
            ['message' => 'Actualización exitosa', 
            'data' => new PqrResource($pqr)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pqr $pqr)
    {
        $this->authorize('delete', $pqr);
        $pqr->delete();

        return response()->json(['message' => 'Eliminación exitosa'], Response::HTTP_OK);
    }
}

