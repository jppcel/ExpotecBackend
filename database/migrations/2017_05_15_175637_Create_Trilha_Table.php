<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrilhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Trilha', function (Blueprint $table) {
          $table->increments("id");
          $table->string("nome", 50);
          $table->date("diaInicio");
          $table->date("diaFim");
          $table->integer("limite")->nullable();
          $table->integer("vagas")->nullable();
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
        Schema::dropIfExists('Trilha');
    }
}
