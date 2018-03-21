<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResetPasswordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('ResetPassword', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Person_id")->unsigned();
          $table->string("token", 100);
          $table->boolean("is_used")->default(false);
          $table->foreign("Person_id")->references("id")->on("Person");
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
        Schema::dropIfExists('ResetPassword');
    }
}
