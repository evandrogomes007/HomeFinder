<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ImovelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HomeFinder — Rotas Web
|--------------------------------------------------------------------------
*/

// ── Página inicial / feed público ─────────────────────────────────────────
Route::get('/', [ClienteController::class, 'index'])->name('HomeFinder');

// ── Autenticação ───────────────────────────────────────────────────────────
Route::get('/entrar',   [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/entrar',  [AuthController::class, 'login'])->name('auth.login');
Route::post('/sair',    [AuthController::class, 'logout'])->name('logout');

// ── Registo de clientes ───────────────────────────────────────────────────
Route::get('/registar',   [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/registar',  [ClienteController::class, 'store'])->name('clientes.store');

// ── Área autenticada ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Clientes
    Route::get('/perfil/{cliente}',      [ClienteController::class, 'show'])->name('clientes.show');
    Route::get('/perfil/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/perfil/{cliente}',      [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/perfil/{cliente}',   [ClienteController::class, 'destroy'])->name('clientes.destroy');

    // Imóveis
    Route::get('/publicar',   [ImovelController::class, 'create'])->name('imoveis.create');
    Route::post('/publicar',  [ImovelController::class, 'store'])->name('imoveis.store');
    Route::get('/meus-imoveis', [ImovelController::class, 'meusImoveis'])->name('imoveis.meu');
    Route::delete('/imoveis/{imovel}', [ImovelController::class, 'destroy'])->name('imoveis.destroy');
    Route::get('/imoveis/{imovel}', [ImovelController::class, 'show'])->name('imoveis.show');
    Route::get('/imoveis/{imovel}/editar', [ImovelController::class, 'edit'])->name('imoveis.edit');
    Route::put('/imoveis/{imovel}', [ImovelController::class, 'update'])->name('imoveis.update');

});
