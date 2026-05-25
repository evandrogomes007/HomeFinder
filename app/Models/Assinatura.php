<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assinatura extends Model
{
    use HasFactory, SoftDeletes;

    // ── Atributos definidos no enunciado ──────────────────────────────────────
    protected $fillable = [
        'data_inicio',
        'data_fim',
        'valor',
        // Campos de suporte
        'cliente_id',
        'plano_id',
        'status',
        'renovacao_automatica',
        'cancelada_em',
        'motivo_cancelamento',
    ];

    protected $casts = [
        'data_inicio'          => 'date',
        'data_fim'             => 'date',
        'valor'                => 'decimal:2',
        'renovacao_automatica' => 'boolean',
        'cancelada_em'         => 'datetime',
    ];

    // ── Relacionamentos ───────────────────────────────────────────────────────

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class);
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    public function estaAtiva(): bool
    {
        return $this->status === 'ativa'
            && $this->data_fim->isFuture();
    }

    public function diasRestantes(): int
    {
        if (!$this->estaAtiva()) {
            return 0;
        }

        return (int) now()->diffInDays($this->data_fim, false);
    }

    public function cancelar(string $motivo = null): void
    {
        $this->update([
            'status'               => 'cancelada',
            'cancelada_em'         => now(),
            'motivo_cancelamento'  => $motivo,
            'renovacao_automatica' => false,
        ]);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAtivas($query)
    {
        return $query->where('status', 'ativa')
            ->where('data_fim', '>=', now()->toDateString());
    }

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeVencidas($query)
    {
        return $query->where('data_fim', '<', now()->toDateString())
            ->whereNotIn('status', ['cancelada', 'expirada']);
    }
}
