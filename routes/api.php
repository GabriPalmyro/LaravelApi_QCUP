<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\TimeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register.api');
    Route::get('/ligas', [LigaController::class, 'mostrarLigas'])->name('ligas.api');
    Route::get('/times', [TimeController::class, 'index'])->name('index.api');
    Route::post('/jogadores', [TimeController::class, 'buscarJogadoresDoTimePeloId'])->name('buscarJogadores.api');
    Route::post('/nova-liga', [LigaController::class, 'adicionarNovaLiga'])->name('novaLiga.api');
    Route::post('/times/ligas', [TimeController::class, 'buscarLigasDoTime'])->name('buscarLigasDoTime.api');
    Route::post('/liga/times', [LigaController::class, 'buscarTimesDaLiga'])->name('buscarTimesDaLiga.api');
    Route::post('/liga', [LigaController::class, 'buscarLigaPorId'])->name('buscarLigaPorId.api');
    Route::get('/email-send', [MailController::class, 'sendEmail'])->name('sendEmailTeste.api');
    Route::post('/forgot-password', [TimeController::class, 'esqueciASenha'])->name('esqueciASenha.api');
    Route::post('/reset-password', [TimeController::class, 'recuperarSenha'])->name('recuperarSenha.api');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/time-data', [ApiAuthController::class, 'getTimeData'])->name('timeData.api');
    Route::get('/logout', [ApiAuthController::class, 'logout'])->name('logout.api');
    Route::get('/refresh', [ApiAuthController::class, 'refresh'])->name('refresh.api');
    Route::post('times/novo-jogador', [JogadorController::class, 'adicionarJogadorAoTime'])->name('adicionarJogador.api');
    Route::post('times/participar-liga', [TimeController::class, 'cadastrarTimeEmLiga'])->name('cadastrarTimeEmLiga.api');
});

Route::group(["middleware" => ["auth:api"]], function(){ 
});
