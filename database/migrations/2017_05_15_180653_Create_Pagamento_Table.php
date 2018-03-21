<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Payment', function (Blueprint $table) {
          $table->increments("id");
          $table->integer("Subscription_id")->unsigned();
          $table->string("Transaction_id");
          $table->string("code");
          $table->integer("paymentStatus");
          $table->foreign("Subscription_id")->references("id")->on("Subscription");
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
