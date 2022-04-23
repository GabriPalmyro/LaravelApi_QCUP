<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLiga extends Model
{
    use HasFactory;

    protected $table = 'time_ligas';
    protected $fillable = ['id_liga', 'id_time', 'pontos', 'vitorias', 'derrotas', 'empates'];

}
