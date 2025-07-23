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
        Schema::table('livros', function (Blueprint $table) {
            // 1. Adiciona a coluna, mas sem unique ainda
            $table->uuid('uuid')->nullable()->after('id_livro');
        });

        // 2. Preenche os UUIDs para livros existentes
        \App\Models\Livro::whereNull('uuid')->get()->each(function ($livro) {
            $livro->uuid = Str::uuid();
            $livro->save();
        });

        // 3. Agora adiciona a restrição UNIQUE
        Schema::table('livros', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
        $table->dropColumn('uuid');
        });
    }
};
