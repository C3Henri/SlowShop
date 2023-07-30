<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//recursos iniciais dos clientes
Route::get('/verificar-email/{token}', [ClienteController::class, 'verifyEmail']);
Route::post('/clientes/register', [ClienteController::class, 'store']);
Route::post('/clientes/login', [ClienteController::class, 'login']);
Route::post('/clientes/esqueci-senha', [ClienteController::class, 'forgotPassword']);
Route::post('/clientes/resetar-senha', [ClienteController::class, 'resetPassword']);

//recurcos protegidos dos clientes
Route::middleware('auth:api-cliente')->group(function () {
    Route::group(['prefix' => 'cliente'], function () {
        Route::get('/logout', [ClienteController::class, 'logout']);
        Route::get('/my-account', [ClienteController::class, 'show']);
        Route::get('/reviews', [ClienteController::class, 'reviews']);
        Route::get('/pedidos', [ClienteController::class, 'pedidos']);
        Route::get('/pedidos/{id}', [ClienteController::class, 'pedido']);
    });

    //recursos para editar
    Route::group(['prefix' => 'cliente/editar'], function () {
        Route::put('/review/{id}', [ClienteController::class, 'updateReview']);
        Route::put('/my-account', [ClienteController::class, 'update']);
    });
});

//recursos de produtos
Route::group(['prefix' => 'produtos'], function () {
    Route::get('/', [ProdutoController::class, 'index']);
    Route::get('/{id}', [ProdutoController::class, 'show']);
    Route::get('/{id}/reviews', [ProdutoController::class, 'reviews']);
    Route::get('/categoria/{id}', [ProdutoController::class, 'categoria']);
});