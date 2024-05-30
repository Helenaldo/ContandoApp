<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Painel\ClienteController;
use App\Http\Middleware\AuthenticateApi;
use App\Livewire\Painel\Cliente\Create;
use App\Livewire\Painel\Cliente\Listar;
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
    Route::resource('/painel/clientes', ClienteController::class);


});



Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', LoginController::class)->name('login.post');

