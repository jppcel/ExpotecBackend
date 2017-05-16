<?php

use Illuminate\Database\Seeder;

class AtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('Atividade')->insert([
          'id' => 1,
          'nome' => 'Expotec 1',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-09 19:30:00',
          'dataFim' => '2017-08-09 22:40:00',
          'Trilha_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 2,
          'nome' => 'Expotec 2',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-10 19:30:00',
          'dataFim' => '2017-08-10 22:40:00',
          'Trilha_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 3,
          'nome' => 'Expotec 3',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-11 19:30:00',
          'dataFim' => '2017-08-11 22:40:00',
          'Trilha_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 4,
          'nome' => 'TADS Magna',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-09 19:30:00',
          'dataFim' => '2017-08-09 21:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 5,
          'nome' => 'TADS TED 1',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-09 21:30:00',
          'dataFim' => '2017-08-09 22:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 6,
          'nome' => 'TADS TED 2',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-09 22:00:00',
          'dataFim' => '2017-08-09 22:30:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 7,
          'nome' => 'TADS 2 TED 1',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-10 19:30:00',
          'dataFim' => '2017-08-10 20:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 8,
          'nome' => 'TADS 2 TED 2',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-10 20:00:00',
          'dataFim' => '2017-08-10 20:30:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 9,
          'nome' => 'TADS 2 TED 3',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-10 20:30:00',
          'dataFim' => '2017-08-10 21:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 10,
          'nome' => 'TADS 2 TED 4',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-10 21:15:00',
          'dataFim' => '2017-08-10 21:45:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 11,
          'nome' => 'TADS 2 TED 5',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-10 21:45:00',
          'dataFim' => '2017-08-10 22:15:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 12,
          'nome' => 'TADS Minicurso 1',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-11 19:30:00',
          'dataFim' => '2017-08-11 22:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 13,
          'nome' => 'TADS Minicurso 2',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-11 19:30:00',
          'dataFim' => '2017-08-11 22:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 14,
          'nome' => 'TADS Minicurso 3',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-11 19:30:00',
          'dataFim' => '2017-08-11 22:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 15,
          'nome' => 'TADS Minicurso 4',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-11 19:30:00',
          'dataFim' => '2017-08-11 22:00:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 16,
          'nome' => 'TADS Encerramento',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-11 22:00:00',
          'dataFim' => '2017-08-11 22:30:00',
          'Trilha_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Atividade')->insert([
          'id' => 17,
          'nome' => 'Almoço',
          'palestrante' => 'Palestrante Exemplo',
          'dataInicio' => '2017-08-12 10:30:00',
          'dataFim' => '2017-08-12 15:00:00',
          'Trilha_id' => 3,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
    }
}
