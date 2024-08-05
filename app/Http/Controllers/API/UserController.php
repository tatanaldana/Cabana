<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scope:admin','permission:view general'])->only('index');
        $this->middleware(['scope:admin,cliente','permission:view general|ver personal cliente'])->only('show');
        $this->middleware(['scope:admin', 'permission:create general'])->only('store');
        $this->middleware(['scope:admin,cliente', 'permission:edit general|edicion parcial'])->only('update');
        $this->middleware(['scope:admin,cliente', 'permission:delete general|Eliminacion parcial'])->only('destroy');

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
    public function show(User $user)
    {   
        $this->authorize('view', $user);

        return response()->json([
            'message' => 'Usuario obtenido exitosamente',
            'user' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
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
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente'
        ], Response::HTTP_OK);
    }
}
