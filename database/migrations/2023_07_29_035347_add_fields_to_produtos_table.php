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
        Schema::table('produtos', function (Blueprint $table) {
            $table->decimal('preco', 8, 2)->nullable();
            $table->string('imagem')->nullable();
            $table->text('descricao')->nullable();
            $table->integer('quantidade_total')->default(0);
            $table->integer('quantidade_comprada')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('preco');
            $table->dropColumn('imagem');
            $table->dropColumn('descricao');
            $table->dropColumn('quantidade_total');
            $table->dropColumn('quantidade_comprada');
        });
    }
};
