<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmEmail;
use App\Mail\AddPlayerEmail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail() {
        $details = [
            "title" => "E-mail teste",
            "body" => "Isso é um e-mail teste"
        ];

        Mail::to("gabripalmyro13579@gmail.com")->send(new ConfirmEmail($details));
        return "E-mail sent succesful";
    }

    public function sendEmailJogador()
    {
        $details = [
            "title" => "Você foi adicionado a um time!",
            "body" => "O adicionou você na composição",
            "nome" => "União Fiasco"
        ];

        $email = new AddPlayerEmail($details);

        Mail::to("gabripalmyro13579@gmail.com")->send($email);
        return "E-mail sent succesful";

    }
}
