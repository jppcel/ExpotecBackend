<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('PaymentMethod')){
        Schema::create('PaymentMethod', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->string("tag");
            $table->dateTime("startDate");
            $table->dateTime("endDate");
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
        Schema::dropIfExists('PaymentMethod');
    }
}
