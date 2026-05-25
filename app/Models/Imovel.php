<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imovel extends Model
{
    use HasFactory;

    protected $table = 'imoveis'; 

    protected $fillable = [
        'cliente_id', 'titulo', 'descricao', 'localizacao', 'preco',
        'tipo', 'status', 'quartos', 'banheiros', 'area_m2', 'imagens', 'ativo'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'imagens' => 'array',
        'ativo' => 'boolean',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true)->where('status', 'disponivel');
    }
}