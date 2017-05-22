<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('User', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Person_id")->unsigned();
          $table->string("password", 60)->nullable();
          $table->boolean("is_admin");
          $table->boolean("is_active");
          $table->datetime("last_update");
          $table->rememberToken();
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
        Schema::dropIfExists('User');
    }
}
