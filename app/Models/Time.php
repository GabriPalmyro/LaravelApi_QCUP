<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Passport\HasApiTokens;

class Time extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'times';
    protected $fillable = ['nome', 'email', 'senha', 'logo', 'remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    } 

    public function jogadores()
    {
        return $this->hasMany(Jogador::class, 'id_time');
    }

    public function ligas()
    {
        return $this->belongsToMany(Liga::class, 'time_ligas', 'id_time', 'id_liga')
            ->withPivot('pontos', 'vitorias', 'derrotas', 'empates');
    }

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'time_partidas', 'id_time', 'id_partida')
        ->withPivot('pontuacao');
    }

    public function AauthAcessToken(){
        return $this->hasMany(OauthAccessToken::class);
    }
}
