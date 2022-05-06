<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Time;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ApiAuthController extends Controller
{

    public function register(Request $request)
    {
        $messages = [
            'email.unique' => 'E-mail já cadastrado.',
        ];

        $validator = Validator::make($request->all(), [
            'nome'  =>      'required|string|max:100',
            'email' =>      'required|string|email|max:150|unique:times',
            'senha' =>      'required|string|min:6',
            'logo'  =>      'required|string|max:200',
        ], $messages);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first('email')], 422);
        }

        $time = Time::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request['senha']),
            'logo' => $request->logo,
        ]);

        $token = $time->createToken('auth_token')->accessToken;

        return response()
            ->json(["time" => $time, "token" => $token,]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:150',
            'senha' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['erro' => $validator->errors()], 422);
        }
        $time = Time::where('email', $request->email)->first();
        if ($time) {
            if (Hash::check($request->senha, $time->senha)) {
                $token = $time->createToken('auth_token')->accessToken;
                $response = ["time" => $time, "token" => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Senha incorreta."];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'Time não cadastrado.'];
            return response($response, 400);
        }
    }

    public function authenticatedTimeDetails()
    {
        //returns details
        return response()->json(['time' => auth()->user()], 200);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
        }
        $response = ['message' => 'Você foi desconectado com sucesso'];
        return response($response, 200);
    }
}
