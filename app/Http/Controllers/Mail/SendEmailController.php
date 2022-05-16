<?php

namespace App\Http\Controllers;
use App\Mail\AddPlayerEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function SendEmailTeste()
    {
        $details = [
            'title' => 'Você foi adicionado a um time!',
            'body' => "O adicionou você na composição",
            'nome' => "teste"
        ];

        Mail::to("gabripalmyro13579@gmail.com")->send(new AddPlayerEmail($details));

    }
}
