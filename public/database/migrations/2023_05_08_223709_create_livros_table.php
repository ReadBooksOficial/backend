<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id("id_livro");
            $table->unsignedBigInteger("id_usuario");//precisar ser unsignedBigInteger para ser chave estrangeira
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->string("img_livro")->nullable();
            $table->string("nome_livro");
            $table->text("descricao_livro")->nullable();
            $table->string("lido");
            $table->string("tempo_lido");
            $table->string("paginas_lidas");
            $table->string("total_paginas")->nullable();
            $table->string("data_inicio");
            $table->string("data_termino")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livros');
    }
};
