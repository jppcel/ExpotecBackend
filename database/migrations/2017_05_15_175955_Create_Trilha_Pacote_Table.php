<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrilhaPacoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Track_Package', function (Blueprint $table) {
          $table->integer("Track_id")->unsigned();
          $table->integer("Package_id")->unsigned();
          $table->foreign("Track_id")->references("id")->on("Track");
          $table->foreign("Package_id")->references("id")->on("Package");
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
        Schema::dropIfExists('Track_Package');
    }
}
