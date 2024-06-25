<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegistroController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\DetpromocioneController;
use App\Http\Controllers\API\DetventaController;
use App\Http\Controllers\API\MatprimaController;
use App\Http\Controllers\API\PqrController;
use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\PromocioneController;
use App\Http\Controllers\API\ProveedoreController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VentaController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login',[LoginController::class,'store']);
Route::post('registro',[RegistroController::class,'store']);


Route::apiResource('categorias',CategoriaController::class);
Route::apiResource('productos',ProductoController::class);
Route::apiResource('detpromociones',DetpromocioneController::class);
Route::apiResource('detventas',DetventaController::class);
Route::apiResource('matprimas',MatprimaController::class);
Route::apiResource('pqrs',PqrController::class);
Route::apiResource('promociones',PromocioneController::class);
Route::apiResource('proveedores',ProveedoreController::class);
Route::apiResource('users',UserController::class);
Route::apiResource('ventas',VentaController::class);



/*
Route::prefix('categoria')->group(function(){
    Route::get('/', [CategoriaController::class, 'index']);
    Route::post('/buscar', [CategoriaController::class, 'store']);
    Route::get('/{id}',[CategoriaController::class,'show']);
    Route::put('/{id}',[CategoriaController::class,'update']);
    Route::delete('/{id}',[CategoriaController::class,'destroy']);
});*/