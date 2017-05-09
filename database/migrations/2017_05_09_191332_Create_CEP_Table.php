<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCEPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('CEP', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Cidade_Cod_Ibge")->unsigned();
          $table->string("TipoLogradouro", 30)->nullable();
          $table->string("Logradouro", 60)->nullable();
          $table->string("Bairro", 80)->nullable();
          $table->string("CEP", 9);
          $table->boolean("CEPUnico");
          $table->foreign("Cidade_Cod_Ibge")->references("Cod_Ibge")->on("Cidade");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CEP');
    }
}
