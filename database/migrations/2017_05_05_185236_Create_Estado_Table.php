<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('State', function (Blueprint $table) {
           $table->integer("id")->unsigned();
           $table->integer("Country_id")->unsigned();
           $table->string("name", 30);
           $table->string("UF", 2);
           $table->foreign("Country_id")->references("id")->on("Country");
           $table->primary("id");
       });

        DB::Table('State')->insert(array('id' => 1, 'Country_id' => 1, 'name' => 'Alagoas', 'UF' => 'AC' ));
        DB::Table('State')->insert(array('id' => 2, 'Country_id' => 1, 'name' => 'Acre', 'UF' => 'AL' ));
        DB::Table('State')->insert(array('id' => 3, 'Country_id' => 1, 'name' => 'Amazonas', 'UF' => 'AM' ));
        DB::Table('State')->insert(array('id' => 4, 'Country_id' => 1, 'name' => 'Amapá', 'UF' => 'AP' ));
        DB::Table('State')->insert(array('id' => 5, 'Country_id' => 1, 'name' => 'Bahia', 'UF' => 'BA' ));
        DB::Table('State')->insert(array('id' => 6, 'Country_id' => 1, 'name' => 'Ceará', 'UF' => 'CE' ));
        DB::Table('State')->insert(array('id' => 7, 'Country_id' => 1, 'name' => 'Distrito Federal', 'UF' => 'DF' ));
        DB::Table('State')->insert(array('id' => 8, 'Country_id' => 1, 'name' => 'Espírito Santo', 'UF' => 'ES' ));
        DB::Table('State')->insert(array('id' => 9, 'Country_id' => 1, 'name' => 'Goiás', 'UF' => 'GO' ));
        DB::Table('State')->insert(array('id' => 10, 'Country_id' => 1, 'name' => 'Maranhão', 'UF' => 'MA' ));
        DB::Table('State')->insert(array('id' => 11, 'Country_id' => 1, 'name' => 'Minas Gerais', 'UF' => 'MG' ));
        DB::Table('State')->insert(array('id' => 12, 'Country_id' => 1, 'name' => 'Mato Grosso do Sul', 'UF' => 'MS' ));
        DB::Table('State')->insert(array('id' => 13, 'Country_id' => 1, 'name' => 'Mato Grosso', 'UF' => 'MT' ));
        DB::Table('State')->insert(array('id' => 14, 'Country_id' => 1, 'name' => 'Pará', 'UF' => 'PA' ));
        DB::Table('State')->insert(array('id' => 15, 'Country_id' => 1, 'name' => 'Paraíba', 'UF' => 'PB' ));
        DB::Table('State')->insert(array('id' => 16, 'Country_id' => 1, 'name' => 'Pernambuco', 'UF' => 'PE' ));
        DB::Table('State')->insert(array('id' => 17, 'Country_id' => 1, 'name' => 'Piauí', 'UF' => 'PI' ));
        DB::Table('State')->insert(array('id' => 18, 'Country_id' => 1, 'name' => 'Paraná', 'UF' => 'PR' ));
        DB::Table('State')->insert(array('id' => 19, 'Country_id' => 1, 'name' => 'Rio de Janeiro', 'UF' => 'RJ' ));
        DB::Table('State')->insert(array('id' => 20, 'Country_id' => 1, 'name' => 'Rio Grande do Norte', 'UF' => 'RN' ));
        DB::Table('State')->insert(array('id' => 21, 'Country_id' => 1, 'name' => 'Rondônia', 'UF' => 'RO' ));
        DB::Table('State')->insert(array('id' => 22, 'Country_id' => 1, 'name' => 'Roraima', 'UF' => 'RR' ));
        DB::Table('State')->insert(array('id' => 23, 'Country_id' => 1, 'name' => 'Rio Grande do Sul', 'UF' => 'RS' ));
        DB::Table('State')->insert(array('id' => 24, 'Country_id' => 1, 'name' => 'Santa Catarina', 'UF' => 'SC' ));
        DB::Table('State')->insert(array('id' => 25, 'Country_id' => 1, 'name' => 'Sergipe', 'UF' => 'SE' ));
        DB::Table('State')->insert(array('id' => 26, 'Country_id' => 1, 'name' => 'São Paulo', 'UF' => 'SP' ));
        DB::Table('State')->insert(array('id' => 27, 'Country_id' => 1, 'name' => 'Tocantins', 'UF' => 'TO' ));
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('State');
     }
}
