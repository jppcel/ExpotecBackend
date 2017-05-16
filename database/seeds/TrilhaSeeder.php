<?php

use Illuminate\Database\Seeder;

class TrilhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Trilha')->insert([
          'id' => 1,
          'nome' => 'Expotec',
          'diaInicio' => '2017-08-09',
          'diaFim' => '2017-08-11',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Trilha')->insert([
          'id' => 2,
          'nome' => 'TADS',
          'diaInicio' => '2017-08-09',
          'diaFim' => '2017-08-11',
          'limite' => 200,
          'vagas' => 200,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Trilha')->insert([
          'id' => 3,
          'nome' => 'Almoço',
          'diaInicio' => '2017-08-12',
          'diaFim' => '2017-08-12',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
    }
}
