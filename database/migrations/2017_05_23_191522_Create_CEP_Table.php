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
      Schema::create('ZIP', function (Blueprint $table) {
          $table->integer("id")->unsigned();
          $table->integer("TypeStreet_id")->unsigned()->nullable();
          $table->integer("City_Cod_Ibge")->unsigned();
          $table->string("name", 100)->nullable();
          $table->string("neighborhood", 100)->nullable();
          $table->string("zipcode", 8);
          $table->foreign("City_Cod_Ibge")->references("Cod_Ibge")->on("City");
          $table->foreign("TypeStreet_id")->references("TypeStreet")->on("City");
          $table->primary("id");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('ZIP');
    }
}
