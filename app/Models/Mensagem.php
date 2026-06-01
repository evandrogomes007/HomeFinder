<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    protected $table = 'mensagens';

    protected $fillable = [
        'conversa_id',
        'remetente_id',
        'mensagem',
        'lida'
    ];
    
    public function conversa() { return $this->belongsTo(Conversa::class); }
    public function remetente() { return $this->belongsTo(Cliente::class, 'remetente_id'); }
}
