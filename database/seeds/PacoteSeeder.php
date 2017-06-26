<?php

use Illuminate\Database\Seeder;

class PacoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Package')->insert([
            'id' => 1,
            'name' => 'Expotec',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Expotec",
            'Event_id' => 1,
        ]);
        DB::table('Package')->insert([
            'id' => 2,
            'name' => 'Expotec + Almoço',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Expotec + Almoço no Sábado",
            'Event_id' => 1,
        ]);
        DB::table('Package')->insert([
            'id' => 3,
            'name' => 'Univel Insights - Minicurso 1',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 1",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 4,
            'name' => 'Univel Insights - Minicurso 2',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 2",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 5,
            'name' => 'Univel Insights - Minicurso 3',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 3",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 6,
            'name' => 'Univel Insights - Minicurso 4',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 4",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 7,
            'name' => 'Univel Insights + Almoço - Minicurso 1',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 1 + Almoço do Sábado",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 8,
            'name' => 'Univel Insights + Almoço - Minicurso 2',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 2 + Almoço do Sábado",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 9,
            'name' => 'Univel Insights + Almoço - Minicurso 3',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 3 + Almoço do Sábado",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 10,
            'name' => 'Univel Insights + Almoço - Minicurso 4',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Trilha das palestras da Univel Insights + o Minicurso 4 + Almoço do Sábado",
            'Event_id' => 2,
        ]);
        DB::table('Package')->insert([
            'id' => 11,
            'name' => 'Almoço',
            'value' => 25.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => "Almoço do Sábado",
            'Event_id' => 1,
        ]);
    }
}
