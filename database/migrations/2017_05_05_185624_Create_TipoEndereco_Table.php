<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEnderecoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('TypeStreet', function (Blueprint $table) {
        $table->integer("id")->unsigned();
        $table->string("name", 40);
        $table->primary("id");
      });

      DB::Table('TypeStreet')->insert(array('id' => 1, 'name' => '10ª Avenida'));
      DB::Table('TypeStreet')->insert(array('id' => 2, 'name' => '10ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 3, 'name' => '11ª Avenida'));
      DB::Table('TypeStreet')->insert(array('id' => 4, 'name' => '11ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 5, 'name' => '12ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 6, 'name' => '13ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 7, 'name' => '14ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 8, 'name' => '15ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 9, 'name' => '16ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 10, 'name' => '17ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 11, 'name' => '18ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 12, 'name' => '19ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 13, 'name' => '1ª Avenida'));
      DB::Table('TypeStreet')->insert(array('id' => 14, 'name' => '1ª Ladeira'));
      DB::Table('TypeStreet')->insert(array('id' => 15, 'name' => '1ª Paralela'));
      DB::Table('TypeStreet')->insert(array('id' => 16, 'name' => '1ª Rua'));
      DB::Table('TypeStreet')->insert(array('id' => 17, 'name' => '1ª Subida'));
      DB::Table('TypeStreet')->insert(array('id' => 18, 'name' => '1ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 19, 'name' => '1ª Travessa da Rodovia'));
      DB::Table('TypeStreet')->insert(array('id' => 20, 'name' => '1ª Vila'));
      DB::Table('TypeStreet')->insert(array('id' => 21, 'name' => '1º Alto'));
      DB::Table('TypeStreet')->insert(array('id' => 22, 'name' => '1º Beco'));
      DB::Table('TypeStreet')->insert(array('id' => 23, 'name' => '20ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 24, 'name' => '21ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 25, 'name' => '22ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 26, 'name' => '26ª Travessa'));
      DB::Table('TypeStreet')->insert(array('id' => 27, 'name' => '2ª Avenida'));
      DB::Table('TypeStreet')->insert(array('id' => 28, 'name' => '2ª Ladeira'));
      DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => '2ª Paralela'));
      DB::Table('TypeStreet')->insert(array('id' => 30, 'name' => '2ª Rua'));
      DB::Table('TypeStreet')->insert(array('id' => 31, 'name' => '2ª Subida'));
      DB::Table('TypeStreet')->insert(array('id' => 32, 'name' => '2ª Travessa'));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
      // DB::Table('TypeStreet')->insert(array('id' => 29, 'name' => ''));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TypeStreet');
    }
}
