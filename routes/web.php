<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Painel\ClienteContatoController;
use App\Http\Controllers\Painel\ClienteController;
use App\Http\Controllers\Painel\ClienteTributacaoController;
use App\Http\Controllers\Painel\ProcessoController;
use App\Http\Controllers\Painel\ProcessoMovimentoController;
use App\Http\Controllers\Painel\TenantController;
use App\Http\Controllers\Painel\UserController;
use App\Http\Middleware\AuthenticateApi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web', AuthenticateApi::class])
    ->group(function() {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/logout', LogoutController::class)->name('logout');
    Route::resource('/painel/clientes/tributacao', ClienteTributacaoController::class);
    Route::resource('/painel/clientes/contatos', ClienteContatoController::class);
    Route::resource('/painel/clientes', ClienteController::class);

    Route::resource('/processo/movimento', ProcessoMovimentoController::class);

    Route::resource('/processo', ProcessoController::class);
    Route::resource('/user', UserController::class);

    Route::get('/tenant', [TenantController::class, 'index'])->name('tenant.listar');
    Route::get('/tenant/edit', [TenantController::class, 'edit'])->name('tenant.edit');
    Route::put('/tenant', [TenantController::class, 'update'])->name('tenant.update');

    });



Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', LoginController::class)->name('login.post');


