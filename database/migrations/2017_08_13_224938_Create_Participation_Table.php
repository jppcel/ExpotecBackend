<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('Participation')){
        Schema::create('Participation', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("Subscription_id")->unsigned();
            $table->integer("Activity_id")->unsigned();
            $table->time("hours");
            $table->foreign("Subscription_id")->references("id")->on("Subscription");
            $table->foreign("Activity_id")->references("id")->on("Activity");
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
        //
    }
}
