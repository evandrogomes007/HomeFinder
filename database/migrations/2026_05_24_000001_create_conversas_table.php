<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id');
            $table->foreignId('vendedor_id');
            $table->foreignId('imovel_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversas');
    }
};
