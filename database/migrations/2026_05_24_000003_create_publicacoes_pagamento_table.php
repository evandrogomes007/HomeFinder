<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicacoes_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendedor_id');
            $table->foreignId('imovel_id');
            $table->decimal('valor', 10, 2);
            $table->string('metodo_pagamento');
            $table->string('status')->default('pendente');
            $table->string('referencia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicacoes_pagamento');
    }
};
