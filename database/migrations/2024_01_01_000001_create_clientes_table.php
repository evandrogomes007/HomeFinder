<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('primeiro_nome', 100);
            $table->string('ultimo_nome', 100)->nullable();
            $table->enum('genero', ['masculino', 'feminino', 'outro']);
            $table->string('email')->unique();
            $table->string('telefone', 20)->nullable();
            $table->string('nif', 50)->nullable()->unique();
            $table->boolean('ativo')->default(true);
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
