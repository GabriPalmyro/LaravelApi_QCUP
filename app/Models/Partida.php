<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $table = 'partidas';
    protected $fillable = ['id_liga', 'modo', 'jogo', 'data', 'link'];

    /**
     * Os times que participam da partida selecionada
     */
    public function times()
    {
        return $this->belongsToMany(Time::class, 'time_partidas', 'id_partida', 'id_time')->withPivot('pontuacao');
    }

    /**
     * Liga que essa partida se refere
     */
    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }

}
