<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('Estado', function (Blueprint $table) {
           $table->increments("Id");
           $table->integer("Pais_Id")->unsigned();
           $table->string("UF", 2);
           $table->foreign("Pais_Id")->references("Pais")->on("Id");
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('Estado');
     }
}
