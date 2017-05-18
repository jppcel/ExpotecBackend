<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtividadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Atividade', function (Blueprint $table) {
          $table->increments("id");
          $table->string("nome", 50);
          $table->string("palestrante", 70);
          $table->integer("limite")->nullable();
          $table->integer("vagas")->nullable();
          $table->datetime("dataInicio");
          $table->datetime("dataFim");
          $table->integer("Trilha_id")->unsigned();
          $table->foreign("Trilha_id")->references("id")->on("Trilha");
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
