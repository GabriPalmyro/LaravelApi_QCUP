<?php

use App\Http\Controllers\{
    JogadorController,
    TimeController
};

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
