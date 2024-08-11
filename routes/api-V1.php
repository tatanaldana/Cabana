<?php

use App\Http\Controllers\API\Auth\ChangePasswordController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
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
use App\Http\Controllers\API\Auth\RefreshTokenController;
use App\Http\Controllers\API\DB\ProcedimientoController;
use App\Http\Controllers\API\DB\ViewController;
use App\Http\Controllers\API\ImageController;
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
Route::post('logout', [LogoutController::class, 'logout']);
Route::post('refreshToken', [RefreshTokenController::class, 'refreshToken']);
Route::post('changepassword', [ChangePasswordController::class, 'changePassword']);

Route::get('/contar-clientes', [ProcedimientoController::class, 'contarClientesUltimoMes']);
Route::get('/total-ventas', [ProcedimientoController::class, 'totalVentasDiaAnterior']);
Route::get('/contar-ventas', [ProcedimientoController::class, 'contarVentasPorMedioEnv']);

Route::get('/promocion-vendidas', [ViewController::class, 'promocionMasUnidadesVendidas']);
Route::get('/producto-mas-vendido', [ViewController::class, 'productoMasVendido']);
Route::get('/cliente-mas-ventas', [ViewController::class, 'clienteMasVentas']);


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

Route::prefix('images')->group(function () {

    // Obtener todas las imágenes para un modelo específico (relación uno a uno)
    Route::get('{modelType}', [ImageController::class, 'indexAllImages']);

    // Obtener todas las imágenes para un modelo específico (relación uno a uno)
    Route::get('{modelType}/{modelId}', [ImageController::class, 'index']);

    // Obtener una imagen específica de un modelo (relación uno a muchos)
    Route::get('{modelType}/{modelId}/{imageId}', [ImageController::class, 'show']);

    // Crear una nueva imagen para un modelo
    Route::post('', [ImageController::class, 'store']);

    // Actualizar o eliminar imagen para relaciones uno a uno
    Route::put('{modelType}/{modelId}', [ImageController::class, 'updateForOneToOne']);
    Route::delete('{modelType}/{modelId}', [ImageController::class, 'destroyImageForOneToOne']);

    // Actualizar o eliminar imagen para relaciones uno a muchos
    Route::put('{modelType}/{modelId}/{imageId}', [ImageController::class, 'updateForOneToMany']);
    Route::delete('{modelType}/{modelId}/{imageId}', [ImageController::class, 'destroyImageForOneToMany']);

});



/*
Route::prefix('categoria')->group(function(){
    Route::get('/', [CategoriaController::class, 'index']);
    Route::post('/buscar', [CategoriaController::class, 'store']);
    Route::get('/{id}',[CategoriaController::class,'show']);
    Route::put('/{id}',[CategoriaController::class,'update']);
    Route::delete('/{id}',[CategoriaController::class,'destroy']);
});*/