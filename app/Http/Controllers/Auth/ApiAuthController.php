<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;


class ApiAuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $messages = [
            'email.unique' => 'E-mail já cadastrado.',
        ];

        $validator = Validator::make($request->all(), [
            'nome'  =>      'required|string|max:100',
            'email' =>      'required|string|email|max:150|unique:times',
            'password' =>   'required|string|min:6',
            'logo'  =>      'required|string|max:200',
        ], $messages);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->first('email')], 422);
        }

        $time = Time::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'logo' => $request->logo,
        ]);

        $details = [
            'title' => 'Inscrição confirmada!',
            'body' => 'A QCUP confirmou sua inscrição'
        ];

        Mail::to($request->email)->send(new ConfirmEmail($details));

        return response()
            ->json([
                "sucess" => true,
                "message" => 'Time criado com sucesso.',
            ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:150',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response(['erro' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                "sucess" => false,
                "message" => "E-mail ou senha estão errados."
            ]);
        }
        return response()->json(['time' => auth()->user(), 'token' => $token]);
    }

    /**
     * Get the authenticated Time.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimeData()
    {
        return response()->json(auth()->user());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return  response()->json([
            'time' => auth()->user(),
            'token' => auth()->refresh()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Deslogado com suecesso']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
