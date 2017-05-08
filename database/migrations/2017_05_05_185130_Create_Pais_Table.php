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
      Schema::create('Pais', function (Blueprint $table) {
          $table->integer("Id")->unsigned();
          $table->string("Pais", 50);
          $table->primary("Id");
      });
      DB::Table('Pais')->insert(array( 'Id' => 1, 'Pais' => 'BRASIL'));
      DB::Table('Pais')->insert(array( 'Id' => 2, 'Pais' => 'PARAGUAI'));
      DB::Table('Pais')->insert(array( 'Id' => 3, 'Pais' => 'ARGENTINA'));

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
