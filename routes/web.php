<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Rotas protegidas por autenticacao
Route::middleware('auth')->group(function () {

    Route::get('/eventos/create', [EventoController::class, 'create'])
        ->name('eventos.create');

    Route::post('/eventos', [EventoController::class, 'store'])
        ->name('eventos.store');

    // Ticket #005 - Protecao do envio de perguntas
    Route::post('/eventos/{id}/perguntas', [EventoController::class, 'storePergunta'])
        ->name('eventos.perguntas.store');
});

// Rotas publicas
Route::get('/', [EventoController::class, 'index'])
    ->name('eventos.index');

Route::get('/eventos/{id}', [EventoController::class, 'show'])
    ->name('eventos.show');

// Registro de usuarios
Route::get('/register', [RegisterController::class, 'create'])
    ->name('register.create');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

// Autenticacao
Route::get('/login', [LoginController::class, 'create'])
    ->name('login.create');

Route::post('/login', [LoginController::class, 'store'])
    ->name('login.store');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('auth.logout');
