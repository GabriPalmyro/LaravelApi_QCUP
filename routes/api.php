<?php

use App\Http\Controllers\TimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// JOGADOR ROUTES
Route::put('/jogadores/editar', [JogadorController::class, 'update'])->name('jogadores.update');
Route::post('/jogadores', [JogadorController::class, 'store'])->name('jogadores.store');
Route::get('/jogadores', [JogadorController::class, 'index'])->name('jogadores.index');

// TIMES ROUTES
Route::put('/times/editar', [TimeController::class, 'update'])->name('times.update');
Route::post('/times', [TimeController::class, 'store'])->name('times.store');
Route::get('/times', [TimeController::class, 'index'])->name('times.index');
