<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ApiAuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'confirmEmail']]);
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

        Time::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'logo' => $request->logo,
        ]);

        $token = Str::random(64);

        //Create Confirm Email Token
        DB::table('confirm_email')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $action_link = "qcup2021.web.app/my-team/confirm-email?token=" . $token . "&email=" . $request->email;

        $details = [
            'action_link' => $action_link,
            'email' => $request->email
        ];

        Mail::to($request->email)->send(new ConfirmEmail($details));

        return response()
            ->json([
                "sucess" => true,
                "message" => 'Time criado com sucesso.',
            ]);
    }

    /**
     * Login User To System
     *
     * @return void
     */
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

        $time = Time::where('email', $request->email)->first();

        if (!$time)
            return response()->json(['message' => 'Não foi possível encontrar um time com essa credencial.'], 422);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                "message" => "Senha incorreta. Tente novamente ou recupere sua senha."
            ], 422);
        }

        if (!$time->email_verified_at) {
            $tokenEmail = Str::random(64);

            //Create Confirm Email Token
            DB::table('confirm_email')->insert([
                'email' => $request->email,
                'token' => $tokenEmail,
                'created_at' => Carbon::now()
            ]);

            $action_link = "qcup2021.web.app/my-team/confirm-email?token=" . $tokenEmail . "&email=" . $request->email;

            $details = [
                'action_link' => $action_link,
                'email' => $request->email
            ];

            Mail::to($request->email)->send(new ConfirmEmail($details));
            return response()->json(['message' => 'E-mail não verificado. Verifique o e-mail enviado a sua caixa postal para continuar.', 'token' => $token], 401);
        }

        return response()->json(['time' => auth()->user(), 'token' => $token]);
    }

    /**
     * Get the authenticated Time.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     =>          'required|email|exists:times,email',
            'token'     =>          'required|string'
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => $validator->errors()], 422);
        }

        $check_token = DB::table('confirm_email')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$check_token) {
            return response(['success' => false, 'message' => 'Token de confirmação não reconhecido.'], 422);
        } else {

            if ($check_token->is_valid == 0)
                return response(['success' => false, 'message' => 'Token de confirmação expirado ou já utilizado.'], 422);

            Time::where('email', $request->email)->update([
                'email_verified_at' => Carbon::now()
            ]);

            DB::table('confirm_email')->where([
                'email' => $request->email,
                'token' => $request->token
            ])->update([
                'is_valid' => 0
            ]);

            return response(['success' => true, 'message' => 'E-mail confirmado com sucesso!', 'time' => auth()->user()], 200);
        }
    }

    /**
     * Get the authenticated Time.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimeData()
    {
        return response()->json(['time' => auth()->user()]);
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
