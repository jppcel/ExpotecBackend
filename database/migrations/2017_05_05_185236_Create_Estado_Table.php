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
       Schema::create('Estado', function (Blueprint $table) {
           $table->integer("Id")->unsigned();
           $table->integer("Pais_Id")->unsigned();
           $table->string("UF", 2);
           $table->foreign("Pais_Id")->references("Id")->on("Pais");
           $table->primary("Id");
       });

        DB::Table('Estado')->insert(array('Id' => 1, 'Pais_Id' => 1, 'UF' => 'AC' ));
        DB::Table('Estado')->insert(array('Id' => 2, 'Pais_Id' => 1, 'UF' => 'AL' ));
        DB::Table('Estado')->insert(array('Id' => 3, 'Pais_Id' => 1, 'UF' => 'AM' ));
        DB::Table('Estado')->insert(array('Id' => 4, 'Pais_Id' => 1, 'UF' => 'AP' ));
        DB::Table('Estado')->insert(array('Id' => 5, 'Pais_Id' => 1, 'UF' => 'BA' ));
        DB::Table('Estado')->insert(array('Id' => 6, 'Pais_Id' => 1, 'UF' => 'CE' ));
        DB::Table('Estado')->insert(array('Id' => 7, 'Pais_Id' => 1, 'UF' => 'DF' ));
        DB::Table('Estado')->insert(array('Id' => 8, 'Pais_Id' => 1, 'UF' => 'ES' ));
        DB::Table('Estado')->insert(array('Id' => 9, 'Pais_Id' => 1, 'UF' => 'GO' ));
        DB::Table('Estado')->insert(array('Id' => 10, 'Pais_Id' => 1, 'UF' => 'MA' ));
        DB::Table('Estado')->insert(array('Id' => 11, 'Pais_Id' => 1, 'UF' => 'MG' ));
        DB::Table('Estado')->insert(array('Id' => 12, 'Pais_Id' => 1, 'UF' => 'MS' ));
        DB::Table('Estado')->insert(array('Id' => 13, 'Pais_Id' => 1, 'UF' => 'MT' ));
        DB::Table('Estado')->insert(array('Id' => 14, 'Pais_Id' => 1, 'UF' => 'PA' ));
        DB::Table('Estado')->insert(array('Id' => 15, 'Pais_Id' => 1, 'UF' => 'PB' ));
        DB::Table('Estado')->insert(array('Id' => 16, 'Pais_Id' => 1, 'UF' => 'PE' ));
        DB::Table('Estado')->insert(array('Id' => 17, 'Pais_Id' => 1, 'UF' => 'PI' ));
        DB::Table('Estado')->insert(array('Id' => 18, 'Pais_Id' => 1, 'UF' => 'PR' ));
        DB::Table('Estado')->insert(array('Id' => 19, 'Pais_Id' => 1, 'UF' => 'RJ' ));
        DB::Table('Estado')->insert(array('Id' => 20, 'Pais_Id' => 1, 'UF' => 'RN' ));
        DB::Table('Estado')->insert(array('Id' => 21, 'Pais_Id' => 1, 'UF' => 'RO' ));
        DB::Table('Estado')->insert(array('Id' => 22, 'Pais_Id' => 1, 'UF' => 'RR' ));
        DB::Table('Estado')->insert(array('Id' => 23, 'Pais_Id' => 1, 'UF' => 'RS' ));
        DB::Table('Estado')->insert(array('Id' => 24, 'Pais_Id' => 1, 'UF' => 'SC' ));
        DB::Table('Estado')->insert(array('Id' => 25, 'Pais_Id' => 1, 'UF' => 'SE' ));
        DB::Table('Estado')->insert(array('Id' => 26, 'Pais_Id' => 1, 'UF' => 'SP' ));
        DB::Table('Estado')->insert(array('Id' => 27, 'Pais_Id' => 1, 'UF' => 'TO' ));
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('Estado');
     }
}
