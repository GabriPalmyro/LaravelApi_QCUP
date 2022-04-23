<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Post;


use App\Models\Jogador;

class JogadorController extends Controller
{
    public function index()
    {
        $jogadores = Jogador::all();

        return view('jogadores.index', [
            'jogadores' => $jogadores,
        ]);
    }

    public function create()
    {
        return view('jogadores.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome' => 'required|max:150',
            'email' => 'required',
            'nickname' => 'required',
        ]);
        $show = Jogador::create($validatedData);

        return redirect()->route('jogadores.store');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $jogador = Jogador::findOrFail($id);
        return view('jogadores.edit', compact('jogador'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nome' => 'required|max:150',
            'email' => 'required',
            'nickname' => 'required',
        ]);
        $show = Jogador::whereId($id)->update($validatedData);

        return redirect()->route('jogadores.store');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function adicionarJogadorAoTime(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:150',
            'nickname' => 'required|string|max:80',
            'email' => 'required|string|email|max:100',
            'funcao' => 'required|string|max:180',
            'id_time' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['erro' => $validator->errors()], 422);
        }

        $jogador = Jogador::create([
            'nome' => $request->nome,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'funcao' => $request->funcao,
            'id_time' => $request->id_time,
        ]);

        return response()->json(['message' => 'Jogador criado com successo'], 200);
    }
}
