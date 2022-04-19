<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
