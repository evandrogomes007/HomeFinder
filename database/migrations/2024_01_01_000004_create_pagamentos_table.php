<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            // ── Atributos exigidos pelo enunciado ──────────────────────────
            $table->id();
            $table->date('data_pagamento');
            $table->decimal('valor', 10, 2);
            // ── Chaves estrangeiras e controlo ─────────────────────────────
            $table->foreignId('assinatura_id')->constrained('assinaturas')->cascadeOnDelete();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('referencia')->unique();
            $table->enum('metodo', [
                'transferencia_bancaria',
                'multicaixa_express',
                'internet_banking',
                'cartao_credito',
                'cartao_debito',
                'outro',
            ]);
            $table->enum('status', ['pendente', 'aprovado', 'recusado', 'reembolsado'])->default('pendente');
            $table->string('comprovativo')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamp('aprovado_em')->nullable();
            $table->foreignId('aprovado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['cliente_id', 'status']);
            $table->index('referencia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
