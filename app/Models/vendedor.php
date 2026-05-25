<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendedor extends Model
{
    protected $table = 'vendedores';
    
    protected $fillable = [
        'primeiro_nome',
        'ultimo_nome',
        'genero',
        'email',
        'telefone',
        'ativo',
    ];
}
