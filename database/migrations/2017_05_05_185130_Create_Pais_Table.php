<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Country', function (Blueprint $table) {
          $table->integer("id")->unsigned();
          $table->string("name", 50);
          $table->primary("id");
      });
      DB::Table('Country')->insert(array( 'id' => 1, 'name' => 'BRASIL'));
      DB::Table('Country')->insert(array( 'id' => 2, 'name' => 'PARAGUAI'));
      DB::Table('Country')->insert(array( 'id' => 3, 'name' => 'ARGENTINA'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Pais');
    }
}
