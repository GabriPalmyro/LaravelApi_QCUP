<?php

namespace App\Http\Controllers;

use App\Mail\sendResetPasswordEmail;
use Illuminate\Http\Request;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        $response = ["message" => "Time registrado na liga com sucesso"];
        return response($response, 200);
    }

    public function buscarLigasDoTime(Request $request)
    {
        $ligas = Time::find($request->id_time)->ligas()->get();
        return response(["ligas" => $ligas], 200);
    }

    public function esqueciASenha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   =>      'required|string|email',
        ]);

        if ($validator->fails()) {
            return response(['erro' => $validator->errors()], 422);
        }

        $token = Str::random(64);

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $action_link = "qcup2021.web.app/reset-password?token=" . $token . "&email=" . $request->email;

        $data = [
            'action_link' => $action_link,
            'email' => $request->email
        ];

        Mail::to($request->email)->send(new sendResetPasswordEmail($data));

        return response(['success' => true, 'message' => 'E-mail enviado com sucesso'], 200);
    }

    public function recuperarSenha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     =>          'required|email|exists:times,email',
            'password'  =>          'required|min:5|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => $validator->errors()], 422);
        }

        $check_token = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$check_token) {
            return response(['success' => false, 'message' => 'Token de recuperação não reconhecido.'], 422);
        } else {

            if ($check_token->is_valid == 0)
                return response(['success' => false, 'message' => 'Token expirado ou já utilizado.'], 422);

            Time::where('email', $request->email)->update([
                'password' => bcrypt($request->password)
            ]);
            DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token
            ])->update([
                'is_valid' => 0
            ]);
            return response(['success' => true, 'message' => 'Senha alterada com sucesso!'], 200);
        }
    }
}
