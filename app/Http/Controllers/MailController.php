<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail() {
        $details = [
            'title' => 'E-mail teste',
            'body' => 'Isso é um e-mail teste'
        ];

        Mail::to("gabriel.palmyro@aluno.ifsp.edu.br")->send(new ConfirmEmail($details));
        return "E-mail sent succesful";
    }
}
