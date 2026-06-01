<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversa extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'vendedor_id',
        'imovel_id'
    ];

    public function cliente() { return $this->belongsTo(Cliente::class); }
    public function vendedor() { return $this->belongsTo(Cliente::class, 'vendedor_id'); }
    public function imovel() { return $this->belongsTo(Imovel::class); }
    public function mensagens() { return $this->hasMany(Mensagem::class); }
}
