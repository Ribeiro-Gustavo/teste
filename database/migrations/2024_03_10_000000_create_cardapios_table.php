<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cardapios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('quantidade');
            $table->date('validade')->nullable();
            $table->decimal('preco', 10, 2);
            $table->string('categoria')->nullable();
            $table->string('imagem')->nullable();
            $table->boolean('disponivel')->default(true);
            $table->text('descricao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cardapios');
    }
};
