<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrilhaPacoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Trilha_Pacote', function (Blueprint $table) {
          $table->integer("Trilha_id")->unsigned();
          $table->integer("Pacote_id")->unsigned();
          $table->foreign("Trilha_id")->references("id")->on("Trilha");
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
        Schema::dropIfExists('Trilha_Pacote');
    }
}
