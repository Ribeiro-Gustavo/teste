<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardapiosTable extends Migration
{
    public function up()
    {
        Schema::create('cardapios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 25);
            $table->integer('quantidade')->unsigned();
            $table->decimal('preco', 8, 2)->unsigned();
            $table->string('descricao', 125);
            $table->string('imagem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cardapios');
    }
}
