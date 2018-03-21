<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Check', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("User_id")->unsigned();
          $table->integer("Subscription_id")->unsigned();
          $table->integer("Activity_id")->unsigned();
          $table->dateTime("checked_at");
          $table->foreign("User_id")->references("id")->on("User");
          $table->foreign("Subscription_id")->references("id")->on("Subscription");
          $table->foreign("Activity_id")->references("id")->on("Activity");
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
        Schema::dropIfExists('Check');
    }
}
