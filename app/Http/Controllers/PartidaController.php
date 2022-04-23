<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\Liga;
use Illuminate\Http\Request;

class PartidaController extends Controller
{
    public function mostrarPartidas()
    {
        $dados = Partida::select('id', 'modo', 'jogo', 'data', 'link')->get();
        return response()->json(['partidas' => $dados], 200);
    }

    public function buscarLigaPorPartida(Request $request)
    {
        $liga = Liga::find($request->liga_id);
        return response()->json(['liga' => $liga], 200);
    }
}
