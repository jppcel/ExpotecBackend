<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaInscricaoPacoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Pessoa_Inscricao_Pacote', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Pessoa_id")->unsigned();
          $table->integer("Pacote_id")->unsigned();
          $table->foreign("Pessoa_id")->references("id")->on("Pessoa");
          $table->foreign("Pacote_id")->references("id")->on("Pacote");
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
        Schema::dropIfExists('Atividade');
    }
}
