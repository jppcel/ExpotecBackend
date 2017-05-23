<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtividadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Activity', function (Blueprint $table) {
          $table->increments("id");
          $table->string("name", 70);
          $table->integer("Speaker_id")->unsigned();
          $table->integer("slots")->nullable();
          $table->datetime("startDate");
          $table->datetime("endDate");
          $table->integer("Track_id")->unsigned();
          $table->foreign("Track_id")->references("id")->on("Track");
          $table->foreign("Speaker_id")->references("id")->on("Speaker");
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
        Schema::dropIfExists('Activity');
    }
}
