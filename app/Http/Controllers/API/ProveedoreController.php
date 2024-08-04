<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProveedoreRequest;
use App\Http\Resources\ProveedoreResource;
use App\Models\Proveedore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProveedoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scope:admin','can:view general'])->only('index');
        $this->middleware(['scope:admin','permission:view general'])->only('show');
        $this->middleware(['scope:admin', 'permission:create general'])->only('store');
        $this->middleware(['scope:admin', 'permission:edit general'])->only('update');
        $this->middleware(['scope:admin', 'permission:delete general'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Proveedore::class);
            $proveedores=Proveedore::all();
            return ProveedoreResource::collection($proveedores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProveedoreRequest $request)
    {
            $this->authorize('create', Proveedore::class);

            $data = $request->validated();
            $proveedores=Proveedore::create($data);
            return response()->json([
                'message' => 'Proveedor creado exitosamente',
                'data' => new ProveedoreResource($proveedores)
            ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedore $proveedores)
    {
        $this->authorize('view', Proveedore::class);

        return response()->json([
            'message' => 'Proveedor obtenido exitosamente',
            'data' =>new ProveedoreResource($proveedores)
        ], Response::HTTP_OK);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProveedoreRequest $request,Proveedore $proveedores)
    {
        $this->authorize('update', $proveedores);

        $data = $request->validated();
        $proveedores->update($data);
        return response()->json(
            ['message' => 'Actualización exitosa', 
            'data' => new ProveedoreResource($proveedores)],
             Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedore $proveedores)
    {
        $this->authorize('delete', $proveedores);

        $proveedores->delete();

        return response()->json(['message' => 'Eliminación exitosa'], Response::HTTP_OK);
    }
}
