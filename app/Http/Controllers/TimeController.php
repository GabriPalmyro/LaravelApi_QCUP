<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


use App\Models\Time;

class TimeController extends Controller
{
    public function index()
    {   

        $dados = Time::select('id', 'nome', 'email', 'senha', 'logo')->get();

        return response()->json($dados);


        // return view('times.index', [
        //     'times' => $times,
        // ]);
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
        ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
