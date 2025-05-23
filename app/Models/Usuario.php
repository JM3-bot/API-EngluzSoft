<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'telefone',
        'tipo',
        'email_verificado_em',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected $casts = [
        'email_verificado_em' => 'datetime',
    ];

    // Relationships
    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'usuario_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'usuario_id');
    }

    public function mensagens()
    {
        return $this->hasMany(Mensagem::class, 'usuario_id');
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class, 'usuario_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'usuario_id');
    }

    public function visualizacoes()
    {
        return $this->hasMany(Visualizacao::class, 'usuario_id');
    }

    // Mutator para senha
    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
