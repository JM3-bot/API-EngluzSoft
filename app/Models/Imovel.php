<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Imovel extends Model
{
    use HasFactory;

    protected $table = 'imoveis';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'descricao',
        'preco',
        'endereco',
        'cidade',
        'estado',
        'tipo',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoImovel::class, 'imovel_id');
    }

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'caracteristicas_imovel', 'imovel_id', 'caracteristica_id');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'imovel_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'imovel_id');
    }

    public function visualizacoes()
    {
        return $this->hasMany(Visualizacao::class, 'imovel_id');
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class, 'imovel_id');
    }
}
