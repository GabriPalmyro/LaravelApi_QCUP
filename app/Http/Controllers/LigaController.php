<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LigaController extends Controller
{
    public function mostrarLigas()
    {
        $dados = Liga::select('id', 'nome', 'logo', 'jogo', 'data_inicio', 'data_limite_insc')->get();
        return response()->json($dados);
    }

    public function adicionarNovaLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:150',
            'logo' => 'required|string|max:200',
            'jogo' => 'required|string|max:200',
            'tipo' => 'required|string|max:200',
            'data_inicio' => 'required|date',
            'data_limite_insc' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response(['erro' => $validator->errors()], 422);
        }

        $liga = Liga::create([
            'nome' => $request->nome,
            'logo' => $request->logo,
            'jogo' => $request->jogo,
            'tipo' => $request->tipo,
            'data_inicio' => $request->data_inicio,
            'data_limite_insc' => $request->data_limite_insc,
        ]);

        return response()->json(['message' => 'Liga criada com successo'], 200);
    }

    public function buscarTimesDaLiga(Request $request)
    {
        $times = Liga::find($request->id_liga)->times()->get();
        return response($times, 200);
    }

    public function buscarLigaPorId(Request $request)
    {
        $liga = Liga::find($request->id_liga);
        $times = Liga::find($request->id_liga)->times()->get();

        return response(['liga' => $liga, 'times' => $times], 200);
    }
}
