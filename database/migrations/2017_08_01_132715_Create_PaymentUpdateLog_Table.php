<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentUpdateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('PaymentUpdateLog')){
        Schema::create('PaymentUpdateLog', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("User_id")->unsigned();
            $table->integer("Payment_id")->unsigned();
            $table->integer("from");
            $table->integer("to");
            $table->foreign("User_id")->references("id")->on("User");
            $table->foreign("Payment_id")->references("id")->on("Payment");
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
        Schema::dropIfExists('PaymentUpdateLog');
    }
}
