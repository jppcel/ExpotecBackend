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
      DB::table('Activity')->insert([
          'id' => 1,
          'name' => 'Expotec 1',
          'Speaker_id' => 1,
          'startDate' => '2017-08-09 19:30:00',
          'endDate' => '2017-08-09 22:40:00',
          'Track_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 2,
          'name' => 'Expotec 2',
          'Speaker_id' => 1,
          'startDate' => '2017-08-10 19:30:00',
          'endDate' => '2017-08-10 22:40:00',
          'Track_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 3,
          'name' => 'Expotec 3',
          'Speaker_id' => 1,
          'startDate' => '2017-08-11 19:30:00',
          'endDate' => '2017-08-11 22:40:00',
          'Track_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 4,
          'name' => 'TADS Magna',
          'Speaker_id' => 1,
          'startDate' => '2017-08-09 19:30:00',
          'endDate' => '2017-08-09 21:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 5,
          'name' => 'TADS TED 1',
          'Speaker_id' => 1,
          'startDate' => '2017-08-09 21:30:00',
          'endDate' => '2017-08-09 22:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 6,
          'name' => 'TADS TED 2',
          'Speaker_id' => 1,
          'startDate' => '2017-08-09 22:00:00',
          'endDate' => '2017-08-09 22:30:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 7,
          'name' => 'TADS 2 TED 1',
          'Speaker_id' => 1,
          'startDate' => '2017-08-10 19:30:00',
          'endDate' => '2017-08-10 20:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 8,
          'name' => 'TADS 2 TED 2',
          'Speaker_id' => 1,
          'startDate' => '2017-08-10 20:00:00',
          'endDate' => '2017-08-10 20:30:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 9,
          'name' => 'TADS 2 TED 3',
          'Speaker_id' => 1,
          'startDate' => '2017-08-10 20:30:00',
          'endDate' => '2017-08-10 21:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 10,
          'name' => 'TADS 2 TED 4',
          'Speaker_id' => 1,
          'startDate' => '2017-08-10 21:15:00',
          'endDate' => '2017-08-10 21:45:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 11,
          'name' => 'TADS 2 TED 5',
          'Speaker_id' => 1,
          'startDate' => '2017-08-10 21:45:00',
          'endDate' => '2017-08-10 22:15:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 12,
          'name' => 'TADS Minicurso 1',
          'Speaker_id' => 1,
          'startDate' => '2017-08-11 19:30:00',
          'endDate' => '2017-08-11 22:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 13,
          'name' => 'TADS Minicurso 2',
          'Speaker_id' => 1,
          'startDate' => '2017-08-11 19:30:00',
          'endDate' => '2017-08-11 22:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 14,
          'name' => 'TADS Minicurso 3',
          'Speaker_id' => 1,
          'startDate' => '2017-08-11 19:30:00',
          'endDate' => '2017-08-11 22:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 15,
          'name' => 'TADS Minicurso 4',
          'Speaker_id' => 1,
          'startDate' => '2017-08-11 19:30:00',
          'endDate' => '2017-08-11 22:00:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 16,
          'name' => 'TADS Encerramento',
          'Speaker_id' => 1,
          'startDate' => '2017-08-11 22:00:00',
          'endDate' => '2017-08-11 22:30:00',
          'Track_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
      DB::table('Activity')->insert([
          'id' => 17,
          'name' => 'Almoço',
          'Speaker_id' => 1,
          'startDate' => '2017-08-12 10:30:00',
          'endDate' => '2017-08-12 15:00:00',
          'Track_id' => 3,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s"),
      ]);
    }
}
