<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalestranteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Speaker', function (Blueprint $table) {
          $table->increments("id");
          $table->string("name", 50);
          $table->string("photo")->nullable();
          $table->string("website", 100)->nullable();
          $table->text("description");
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
        Schema::dropIfExists('Speaker');
    }
}
