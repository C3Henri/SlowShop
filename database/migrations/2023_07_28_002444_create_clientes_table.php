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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('verificado')->default(false);
            $table->string('token_de_verificacao')->nullable();
            $table->string('token_de_recuperacao')->nullable();
            $table->dateTime('data_de_expiracao_do_token_de_recuperacao')->nullable();
            $table->foreignId('nivel_id')->constrained('niveis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
