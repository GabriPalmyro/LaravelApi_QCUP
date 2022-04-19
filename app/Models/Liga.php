<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    use HasFactory;

    protected $table = 'ligas';
    protected $fillable = ['nome', 'logo', 'jogo', 'tipo', 'dataInicio', 'dataLimiteInsc', 'idTimeVencedor'];
}
