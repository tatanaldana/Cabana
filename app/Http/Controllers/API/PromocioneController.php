<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PromocioneRequest;
use App\Http\Resources\PromocioneResource;
use App\Models\Promocione;
use Illuminate\Http\Response;

class PromocioneController extends Controller
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
            $data=Promocione::included()->get();
            return PromocioneResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromocioneRequest $request)
    {
            $this->authorize('create', Promocione::class);
            $data = $request->validated();
            $promocione=Promocione::create([
                'nom_promo' => $data['nom_promo'],
                'total_promo' => null,
                'categoria_id' => $data['categoria_id'],
            ]);
            
        return response()->json([
            'message' => 'Promoción creada exitosamente',
            'data' => new PromocioneResource($promocione)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Promocione $promocione)
    {
        $promocione = Promocione::included()->findOrFail($promocione->id);
        
        return response()->json([
            'message' => 'Promociones obtenido exitosamente',
            'data' =>new PromocioneResource($promocione)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromocioneRequest $request,Promocione $promocione)
    {
            $this->authorize('update', $promocione);
            $data = $request->validated();

            $promocione->update([
                'nom_promo' => $data['nom_promo'],
            ]);
            return response()->json([
                'message' => 'Promocion actualizada exitosamente',
                'data' => new PromocioneResource($promocione)
            ], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promocione $promocione)
    {
        $this->authorize('delete', $promocione);

        $promocione->delete();

        return response()->json([
            'message' => 'Promoción eliminada de manera exitosa'
        ], Response::HTTP_OK);

    }
}
