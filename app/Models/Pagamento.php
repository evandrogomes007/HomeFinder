<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Pagamento extends Model
{
    use HasFactory, SoftDeletes;

    // ── Atributos definidos no enunciado ──────────────────────────────────────
    protected $fillable = [
        'data_pagamento',
        'valor',
        // Campos de suporte
        'assinatura_id',
        'cliente_id',
        'referencia',
        'metodo',
        'status',
        'comprovativo',
        'observacoes',
        'aprovado_em',
        'aprovado_por',
    ];

    protected $casts = [
        'data_pagamento' => 'date',
        'valor'          => 'decimal:2',
        'aprovado_em'    => 'datetime',
    ];

    // ── Boot ──────────────────────────────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Pagamento $p) {
            if (empty($p->referencia)) {
                $p->referencia = self::gerarReferencia();
            }
            // data_pagamento padrão = hoje
            if (empty($p->data_pagamento)) {
                $p->data_pagamento = now()->toDateString();
            }
        });
    }

    // ── Relacionamentos ───────────────────────────────────────────────────────

    public function assinatura(): BelongsTo
    {
        return $this->belongsTo(Assinatura::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function aprovadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprovado_por');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public static function gerarReferencia(): string
    {
        do {
            $ref = 'PAG-' . strtoupper(Str::random(8));
        } while (self::where('referencia', $ref)->exists());

        return $ref;
    }

    public function aprovar(int $adminId): void
    {
        $this->update([
            'status'      => 'aprovado',
            'aprovado_em' => now(),
            'aprovado_por'=> $adminId,
        ]);

        // Activar a assinatura associada
        $this->assinatura->update(['status' => 'ativa']);
    }

    public function recusar(string $motivo = null): void
    {
        $this->update([
            'status'      => 'recusado',
            'observacoes' => $motivo,
        ]);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeAprovados($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopeDoMes($query, int $mes = null, int $ano = null)
    {
        return $query
            ->whereMonth('data_pagamento', $mes ?? now()->month)
            ->whereYear('data_pagamento',  $ano  ?? now()->year);
    }
}
