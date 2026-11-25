<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ModeracaoController;
use Illuminate\Support\Facades\Route;

// Rotas protegidas por autenticacao
Route::middleware('auth')->group(function () {

    Route::get('/eventos/create', [EventoController::class, 'create'])
        ->name('eventos.create');

    Route::post('/eventos', [EventoController::class, 'store'])
        ->name('eventos.store');

    // Sprint 03 - Envio protegido de perguntas
    Route::post('/eventos/{id}/perguntas', [EventoController::class, 'storePergunta'])
        ->name('eventos.perguntas.store');

    // Sprint 05 - Exclusao protegida
    Route::delete('/perguntas/{pergunta}', [EventoController::class, 'destroyPergunta'])
        ->name('perguntas.destroy');

    // Sprint 06 - Votacao protegida
    Route::post('/perguntas/{pergunta}/votar', [EventoController::class, 'votar'])
        ->name('perguntas.votar');

    // Sprint 07 - Registrar denuncia
    Route::post('/perguntas/{pergunta}/moderar', [ModeracaoController::class, 'store'])
        ->name('moderacoes.store');

    // Sprint 07 - Painel de moderacao
    Route::get('/eventos/{evento}/moderacoes', [ModeracaoController::class, 'index'])
        ->name('moderacoes.index');

    // Sprint 07 - Atualizar status da denuncia
    Route::patch('/moderacoes/{moderacao}/status', [ModeracaoController::class, 'updateStatus'])
        ->name('moderacoes.updateStatus');
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
