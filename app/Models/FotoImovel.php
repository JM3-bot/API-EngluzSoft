<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoImovel extends Model
{
    use HasFactory;

    protected $table = 'fotos_imoveis';

    protected $fillable = [
        'imovel_id',
        'caminho',
    ];

    public function imovel()
    {
        return $this->belongsTo(Imovel::class, 'imovel_id');
    }
}
