<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('Cidade', function (Blueprint $table) {
           $table->increments("Cod_Ibge");
           $table->integer("Estado_Id")->unsigned();
           $table->string("Cidade", 100);
           $table->foreign("Estado_Id")->references("Estado")->on("Id");
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('Cidade');
     }
}
