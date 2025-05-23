<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caracteristica extends Model
{
    use HasFactory;

    protected $table = 'caracteristicas';

    protected $fillable = ['nome'];

    public function imoveis()
    {
        return $this->belongsToMany(Imovel::class, 'caracteristicas_imovel', 'caracteristica_id', 'imovel_id');
    }
}
