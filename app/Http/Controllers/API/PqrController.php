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
            $this->middleware(['scope:admin', 'can:view general'])->only('index', 'show');
            $this->middleware(['scope:cliente', 'can:ver personal cliente'])->only('show');
            $this->middleware(['scope:admin', 'can:edit general'])->only('update');
            $this->middleware(['scope:cliente', 'can:registro parcial'])->only('store');
            $this->middleware(['scope:admin', 'can:delete general'])->only('destroy');
    }
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Pqr::class);

        $pqrs = Pqr::all();
        return PqrResource::collection($pqrs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PqrRequest $request)
    {
        $this->authorize('create', Pqr::class);

        $data = $request->validated();
        $pqrs = Pqr::create($data);

        return response()->json(
            ['message' => 'Registro creado exitosamente', 'data' => new PqrResource($pqrs)],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->authorize('view', Pqr::class);

        $pqrs = Pqr::included()->findOrFail($id);

        return response()->json($pqrs, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PqrRequest $request, $id)
    {
        $data['estado'] = $request['estado'];

        $pqrs = Pqr::findOrFail($id);
        $pqrs->update($data);

        return response()->json(
            ['message' => 'Actualización exitosa', 
            'data' => $pqrs], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pqrs = Pqr::findOrFail($id);
        $pqrs->delete();

        return response()->json(['message' => 'Eliminación exitosa'], Response::HTTP_OK);
    }
}

