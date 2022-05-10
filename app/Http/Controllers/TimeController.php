<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use Illuminate\Http\Request;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Echo_;

class TimeController extends Controller
{
    public function index()
    {
        $dados = Time::select('id', 'nome', 'email', 'senha', 'logo')->get();
        return response()->json($dados);
    }

    public function buscarJogadoresDoTimePeloId(Request $request)
    {
        $dados = Time::find($request->id_time)->jogadores;
        return response()->json(['jogadores' => $dados], 200);
    }

    public function cadastrarTimeEmLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_time'   =>      'required|string',
            'id_liga'   =>      'required|string',
        ]);

        if ($validator->fails()) {
            return response(["erro" => $validator->errors()], 422);
        }

        $time = Time::find($request->id_time);

        if (count($time->jogadores) < 5) {
            return response(["erro" => "Termine de cadastrar os seus jogadores para concluir"], 422);
        }

        foreach ($time->ligas as &$liga) {
            if ($liga->id == $request->id_liga) {
                return response(["erro" => "Você já está cadastrado nesta liga!"], 422);
            }
        }

        $time->ligas()->attach($request->id_liga);

        $response = ["message" => "Time registrado na liga com"];
        return response($response, 200);
    }

    public function buscarLigasDoTime(Request $request)
    {
        $ligas = Time::find($request->id_time)->ligas()->get();
        return response(["ligas" => $ligas], 200);
    }

    public function create()
    {
        return view('times.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome' => 'required|max:150',
            'email' => 'required',
            'logo' => 'nullable',
        ]);

        try {
            // $imageName = Time::random() . '.' . $request->image->getClientOriginalExtension();
            // Storage::disk('public')->putFileAs('time/image', $request->image, $imageName);
            Time::create($validatedData);
            return response()->json([
                'message' => 'Time Created Successfully!!'
            ]);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while creating a time!!'
            ], 500);
        }

        // $show = Time::create($validatedData);

        // return redirect()->route('times.store');
    }

    public function show(Time $time)
    {
        return response()->json([
            'time' => $time
        ], 200);
    }

    public function edit($id)
    {
        $jogador = Time::findOrFail($id);
        return view('times.edit', compact('jogador'));
    }

    public function update(Request $request, Time $time)
    {
        $validatedData = $request->validate([
            'nome' => 'required|max:150',
            'email' => 'required',
            'nickname' => 'required',
        ]);

        try {
            $time->fill($request->post())->update();

            // if($request->hasFile('image')){
            //     // remove old image
            //     if($if($request->hasFile('image'))) {
            //     // remove old image
            //     if($time->image){
            //         $exists = Storage::disk('public')->exists("time/image/{$time->image}");
            //         if($exists){
            //             Storage::disk('public')->delete("time/image/{$time->image}");
            //         }
            //     }
            //     $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
            //     Storage::disk('public')->putFileAs('time/image', $request->image,$imageName);
            //     $time->image = $imageName->image){
            //         $exists = Storage::disk('public')->exists("time/image/{$time->image}");
            //         if($exists){
            //             Storage::disk('public')->delete("time/image/{$time->image}");
            //         }
            //     }
            //     $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
            //     Storage::disk('public')->putFileAs('time/image', $request->image,$imageName);
            //     $time->image = $imageName;
            // }

            return response()->json([
                'message' => 'Time Updated Successfully!!'
            ]);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while updating a time!!'
            ], 500);
        }
        // $show = Time::whereId($id)->update($validatedData);
        // return redirect()->route('times.store');
    }

    public function destroy(Time $time)
    {
        try {
            // if($time->image){
            //     $exists = Storage::disk('public')->exists("time/image/{$time->image}");
            //     if($exists){
            //         Storage::disk('public')->delete("time/image/{$time->image}");
            //     }
            // }
            $time->delete();
            return response()->json([
                'message' => 'Time Deleted Successfully!!'
            ]);
        } catch (\Exception $e) {
            // \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while deleting a time!!'
            ]);
        }
    }
}
