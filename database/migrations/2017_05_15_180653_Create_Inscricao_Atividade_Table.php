<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscricaoAtividadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Subscription_Activity', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Subscription_id")->unsigned();
          $table->integer("Activity_id")->unsigned();
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
        Schema::dropIfExists('Payment');
    }
}
