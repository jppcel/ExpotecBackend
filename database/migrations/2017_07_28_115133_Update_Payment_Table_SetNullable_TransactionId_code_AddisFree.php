<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaymentTableSetNullableTransactionIdCodeAddisFree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Payment', function (Blueprint $table) {
        $table->string("Transaction_id")->nullable()->change();
        $table->string("code")->nullable()->change();
        $table->boolean("isFree")->default(false);
        });
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
