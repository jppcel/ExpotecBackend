<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Phone', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Person_id")->unsigned();
          $table->string("ddd", 3);
          $table->string("number", 9);
          $table->timestamps();
          $table->foreign("Person_id")->references("id")->on("Person");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Phone');
    }
}
