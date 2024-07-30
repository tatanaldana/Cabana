<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scope:admin','can:view general'])->only('index','show');
        $this->middleware(['scope:cliente','can:view cliente'])->only('show');
        $this->middleware(['scope:admin','can:update general'])->only('update');
        $this->middleware(['scope:cliente','can:update parcial'])->only('update');
        $this->middleware(['scope:admin','can:delete general'])->only('destroy');
        $this->middleware(['scope:cliente','can:Eliminacion parcial'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $user = User::create($data);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => new UserResource($user)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id); 

        $this->authorize('view', $user);

        return response()->json([
            'message' => 'Usuario obtenido exitosamente',
            'user' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $data = $request->validated();
        $user->update($data);

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'user' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); 

        $this->authorize('delete', $user);

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente'
        ], Response::HTTP_OK);
    }
}
