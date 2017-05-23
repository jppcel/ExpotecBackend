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
      Schema::create('Track', function (Blueprint $table) {
          $table->increments("id");
          $table->string("name", 50);
          $table->date("startDay");
          $table->date("endDay");
          $table->integer("slots")->nullable();
          $table->boolean("selectProduct");
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
        Schema::dropIfExists('Track');
    }
}
