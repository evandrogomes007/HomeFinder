<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('imoveis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
        $table->string('titulo');
        $table->text('descricao');
        $table->string('localizacao');
        $table->decimal('preco', 15, 2);
        $table->string('tipo')->default('casa');
        $table->string('status')->default('disponivel');
        $table->integer('quartos')->nullable();
        $table->integer('banheiros')->nullable();
        $table->integer('area_m2')->nullable();
        $table->json('imagens')->nullable();
        $table->boolean('ativo')->default(true);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('imoveis');
    }
};
