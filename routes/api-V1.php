<?php

use App\Http\Controllers\API\Auth\ChangePasswordController;
use App\Http\Controllers\API\Auth\ConfirmationControlller;
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
use App\Http\Controllers\API\PDFController;
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
Route::post('loginmovil',[LoginController::class,'storeMovil']);

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

Route::post('pdf/comprobante', [PDFController::class, 'generatePdf']);

Route::get('/ventaProceso', [VentaController::class, 'ventaProceso']);
Route::get('/ventaCompletado', [VentaController::class, 'ventaCompletado']);

Route::prefix('images')->group(function () {
    Route::get('{modelType}',[ImageController::class, 'index']);
    Route::get('{modelType}/{modelId}/{imageId?}', [ImageController::class, 'show']);
    Route::post('', [ImageController::class, 'store']);
    Route::post('{image}', [ImageController::class, 'updateImage']);
    Route::delete('{modelType}/{modelId}/{imageId}', [ImageController::class, 'destroyImage']);
});


// Ruta para confirmar el correo electrónico
Route::get('confirm-email/{token}', [ConfirmationControlller::class, 'confirmEmail']);
// Ruta para solicitar el restablecimiento de contraseña
Route::post('password-reset-request', [RegistroController::class, 'requestPasswordReset']);
// Ruta para restablecer la contraseña
Route::post('password-reset', [ConfirmationControlller::class, 'resetPassword']);



