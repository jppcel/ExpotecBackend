<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('Certificate')){
        Schema::create('Certificate', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("Subscription_id")->unsigned();
            $table->time("hours");
            $table->string("key",8);
            $table->foreign("Subscription_id")->references("id")->on("Subscription");
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
        Schema::dropIfExists('Certificate');
    }
}
