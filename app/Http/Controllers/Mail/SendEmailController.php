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
            'action_link' => 'sadsadasda',
            'email' => 'gabripalmyro@Hotmail.com'
        ];

        Mail::to("gabripalmyro13579@gmail.com")->send(new ConfirmEmail($details));
    }
}
