<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PerfilController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\TipoDocumentoController;
use \App\Http\Controllers\ReuniaoController;
use \App\Http\Controllers\DocumentoController;
use \App\Http\Controllers\DocumentoHistoricoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function(){
    Route::post('login', [\App\Http\Controllers\UserController::class, "login"]);

});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:api']], function(){
    Route::apiResource('perfil', PerfilController::class);
    Route::apiResource('usuario', UserController::class);
    Route::post('register', [UserController::class, "register"]);
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('validate-token', [UserController::class, "validateToken"]);
    Route::get('logout', [UserController::class, "logout"]);
    Route::apiResource('tipo-documento', TipoDocumentoController::class);
    Route::apiResource('documento', DocumentoController::class);
    Route::apiResource('reuniao', ReuniaoController::class);
    Route::get('visualizar-documento/{documento}', [DocumentoController::class, 'registrarVisualizarDocumento']);
    Route::get('pegar-ultimo-numero-documento/{tipo_documento_id}', [DocumentoController::class, 'pegarUltimoNumeroDocumento']);
    Route::get('pegar-historico-por-documento/{documento}', [DocumentoHistoricoController::class, 'pegarHistoricoPorDocumento']);
    Route::get('mostrar-mudanca-documento/{documento}', [DocumentoController::class, 'mostrarMudanca']);

});

Route::get('assinar-documento/', [DocumentoController::class, "assinarDocumento"]);
