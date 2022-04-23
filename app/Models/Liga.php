<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    use HasFactory;

    protected $table = 'ligas';
    protected $fillable = ['nome', 'logo', 'jogo', 'tipo', 'data_inicio', 'data_limite_insc', 'id_time_vencedor'];

    /**
     * Os times que participam da liga selecionada
     */
    public function times()
    {
        return $this->belongsToMany(Time::class, 'time_ligas', 'id_liga', 'id_time')->withPivot('pontos', 'vitorias', 'derrotas', 'empates');
    }

    /**
     * As partidas dessa liga
     */
    public function partidas()
    {
        return $this->hasMany(Partida::class, 'id_partida');
    }
}
