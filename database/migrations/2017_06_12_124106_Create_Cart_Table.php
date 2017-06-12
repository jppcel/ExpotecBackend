<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Cart', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Person_id")->unsigned();
          $table->integer("Package_id")->unsigned();
          $table->foreign("Person_id")->references("id")->on("Person");
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
        //
    }
}
