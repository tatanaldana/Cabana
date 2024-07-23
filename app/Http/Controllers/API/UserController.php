<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
   /* public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware(['scope:admin','can:view general'])->only('index','show');
        $this->middleware(['scope:cliente','can:view cliente'])->only('show');
        $this->middleware(['scopes:admin','can:update general'])->only('update');
        $this->middleware(['scopes:cliente','can:update parcial'])->only('update');
        $this->middleware(['scopes:admin','can:delete general'])->only('destroy');
        $this->middleware(['scopes:cliente','can:Eliminacion parcial'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //$this->authorize('viewAny', User::class);

            $users = User::all();

            return response()->json($users, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
           // $this->authorize('create', User::class);

            $data = $request->validated();
            $user = User::create($data);

            return response()->json($user, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            //$this->authorize('view', $user);

            return response()->json($user, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

           // $this->authorize('update', $user);

            $data = $request->validated();
            $user->update($data);

            return response()->json(['message' => 'Actualización exitosa', 'data' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            //$this->authorize('delete', $user);

            $user->delete();

            return response()->json(['message' => 'Eliminación exitosa'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
