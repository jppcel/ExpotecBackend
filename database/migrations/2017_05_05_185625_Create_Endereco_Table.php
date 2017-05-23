<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Address', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Person_id")->unsigned();
          $table->integer("TypeStreet_id")->unsigned();
          $table->string("street", 100);
          $table->string("number", 5)->nullable();
          $table->string("complement", 50)->nullable();
          $table->string("neighborhood", 40)->nullable();
          $table->string("zip", 8);
          $table->integer("City_id")->unsigned();
          $table->timestamps();
          $table->foreign("Person_id")->references("id")->on("Person");
          $table->foreign("TypeStreet_id")->references("id")->on("TypeStreet");
          $table->foreign("City_id")->references("id")->on("City");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Address');
    }
}
