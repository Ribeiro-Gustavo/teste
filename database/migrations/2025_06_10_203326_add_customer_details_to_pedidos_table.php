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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('nome_cliente')->after('user_id');
            $table->string('telefone_cliente')->after('nome_cliente');
            $table->string('horario_entrega')->after('endereco_entrega');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['nome_cliente', 'telefone_cliente', 'horario_entrega']);
        });
    }
};
