<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimePartida extends Model
{
    use HasFactory;

    protected $table = 'time_partidas';
    protected $fillable = ['id_time', 'id_partida', 'pontuacao'];
}
