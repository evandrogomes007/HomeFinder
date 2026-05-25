<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'preco',
        'duracao_dias',
        'limite_imoveis',
        'ativo',
        'ordem',
    ];

    protected $casts = [
        'preco'          => 'decimal:2',
        'duracao_dias'   => 'integer',
        'limite_imoveis' => 'integer',
        'ativo'          => 'boolean',
    ];

    // ── Boot ──────────────────────────────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Plano $plano) {
            if (empty($plano->slug)) {
                $plano->slug = Str::slug($plano->nome);
            }
        });
    }

    // ── Relacionamentos ───────────────────────────────────────────────────────

    public function assinaturas(): HasMany
    {
        return $this->hasMany(Assinatura::class);
    }

    public function assinaturasAtivas(): HasMany
    {
        return $this->hasMany(Assinatura::class)->where('status', 'ativa');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function temLimiteIlimitado(): bool
    {
        return $this->limite_imoveis === 0;
    }

    public function calcularDataFim(): string
    {
        return now()->addDays($this->duracao_dias)->toDateString();
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true)->orderBy('ordem');
    }
}
