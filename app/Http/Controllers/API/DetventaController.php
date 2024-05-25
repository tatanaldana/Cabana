<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DetventaRequest;
use App\Http\Resources\DetventaResource;
use App\Models\Detventa;


class DetventaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $detventas = Detventa::included()->sort()->filter()->getOrPaginate();
            return DetventaResource::collection($detventas);
        }catch(\Throwable $th){
            return response()->json(['error'=>$th->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetventaRequest $request)
    {
        $data=$request->validated();
        $user=auth()->user();
        $data['user_id']=$user->id;
        $categoria=Detventa::create($data);
        return DetventaResource::make($categoria);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $detventas = Detventa::included()->where('venta_id', $id)->get();

            $detventasGrouped = $detventas->groupBy('venta_id');
    
            return response()->json( $detventasGrouped, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
