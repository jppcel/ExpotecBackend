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
       Schema::create('City', function (Blueprint $table) {
           $table->increments("id");
           $table->integer("Cod_Ibge")->unsigned()->nullable();
           $table->integer("State_id")->unsigned();
           $table->string("name", 100);
           $table->foreign("State_id")->references("id")->on("State");
           $table->unique("Cod_Ibge");
       });

     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('City');
     }
}
