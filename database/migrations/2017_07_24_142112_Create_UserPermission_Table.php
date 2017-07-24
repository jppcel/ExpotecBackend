<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('UserPermission', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("User_id")->unsigned();
          $table->integer("Permission_id")->unsigned();
          $table->foreign("User_id")->references("id")->on("User");
          $table->foreign("Permission_id")->references("id")->on("Permission");
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
        Schema::dropIfExists('UserPermission');
    }
}
