<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendedores', function (Blueprint $table) {
            $table->id();
            $table->string('primeiro_nome', 100);
            $table->string('ultimo_nome', 100);
            $table->enum('genero', ['masculino', 'feminino', 'outro']);
            $table->string('email')->unique();
            $table->string('telefone', 20)->nullable();
            $table->string('BI', 20)->unique();
            $table->boolean('ativo')->default(true);
            $table->string('senha');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendedores');
    }
};
