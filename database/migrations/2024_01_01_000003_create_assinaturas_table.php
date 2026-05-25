<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assinaturas', function (Blueprint $table) {
            // ── Atributos exigidos pelo enunciado ──────────────────────────
            $table->id();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->decimal('valor', 10, 2);
            // ── Chaves estrangeiras e controlo ─────────────────────────────
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('plano_id')->constrained('planos')->restrictOnDelete();
            $table->enum('status', ['pendente', 'ativa', 'cancelada', 'expirada'])->default('pendente');
            $table->boolean('renovacao_automatica')->default(true);
            $table->timestamp('cancelada_em')->nullable();
            $table->text('motivo_cancelamento')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['cliente_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assinaturas');
    }
};
