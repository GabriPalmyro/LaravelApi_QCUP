<?php

namespace App\Http\Controllers;
use App\Mail\AddPlayerEmail;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function sendEmailTeste()
    {
        $details = [
            'title' => 'Você foi adicionado a um time!',
            'body' => "O adicionou você na composição",
            'nome' => "teste"
        ];

        Mail::to("gabri.palmyro@gmail.com")->send(new ConfirmEmail($details));

    }
}
