<?php

use App\Http\Controllers\{
    JogadorController,
    TimeController
};

use Illuminate\Support\Facades\Route;

// JOGADOR ROUTES
Route::get('/jogadores/editar/{id}', [JogadorController::class, 'edit'])->name('jogadores.edit');
Route::put('/jogadores/editar', [JogadorController::class, 'update'])->name('jogadores.update');
Route::get('/jogadores/create', [JogadorController::class, 'create'])->name('jogadores.create');
Route::post('/jogadores', [JogadorController::class, 'store'])->name('jogadores.store');
Route::get('/jogadores', [JogadorController::class, 'index'])->name('jogadores.index');

// JOGADOR ROUTES
Route::get('/times/editar/{id}', [TimeController::class, 'edit'])->name('times.edit');
Route::put('/times/editar', [TimeController::class, 'update'])->name('times.update');
Route::get('/times/create', [TimeController::class, 'create'])->name('times.create');
Route::post('/times', [TimeController::class, 'store'])->name('times.store');
Route::get('/times', [TimeController::class, 'index'])->name('times.index');

Route::get('/', function () {
    return view('welcome');
});
