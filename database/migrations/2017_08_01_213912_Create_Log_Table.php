<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('Log')){
        Schema::create('Log', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("User_id")->unsigned();
            $table->text("text");
            $table->foreign("User_id")->references("id")->on("User");
            $table->timestamps();
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Log');
    }
}
