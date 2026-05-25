<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'primeiro_nome',
        'ultimo_nome',
        'genero',
        'telefone',
        'email',
        'password',
        'nif',
        'ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'ativo'             => 'boolean',
    ];

    // ── Relacionamentos ───────────────────────────────────────────────────────

    public function assinaturas(): HasMany
    {
        return $this->hasMany(Assinatura::class);
    }

    public function assinaturaAtiva(): HasOne
    {
        return $this->hasOne(Assinatura::class)
            ->where('status', 'ativa')
            ->where('data_fim', '>=', now()->toDateString())
            ->latestOfMany();
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class);
    }

    public function imoveis(): HasMany
    {
        return $this->hasMany(Imovel::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Nome completo dinâmico — não precisa de coluna separada na BD.
     */
    public function getNomeCompletoAttribute(): string
    {
        return trim("{$this->primeiro_nome} {$this->ultimo_nome}");
    }

    public function getTemAssinaturaAtivaAttribute(): bool
    {
        return $this->assinaturas()
            ->where('status', 'ativa')
            ->where('data_fim', '>=', now()->toDateString())
            ->exists();
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeBuscar($query, string $termo)
    {
        return $query->where(function ($q) use ($termo) {
            $q->where('primeiro_nome', 'like', "%{$termo}%")
              ->orWhere('ultimo_nome',  'like', "%{$termo}%")
              ->orWhere('email',        'like', "%{$termo}%")
              ->orWhere('telefone',     'like', "%{$termo}%");
        });
    }
}
