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
        ]);
        DB::table('Package')->insert([
            'id' => 2,
            'name' => 'Expotec + Almoço',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 3,
            'name' => 'TADS - Minicurso 1',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 4,
            'name' => 'TADS - Minicurso 2',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 5,
            'name' => 'TADS - Minicurso 3',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 6,
            'name' => 'TADS - Minicurso 4',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 7,
            'name' => 'TADS + Almoço - Minicurso 1',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 8,
            'name' => 'TADS + Almoço - Minicurso 2',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 9,
            'name' => 'TADS + Almoço - Minicurso 3',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 10,
            'name' => 'TADS + Almoço - Minicurso 4',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 11,
            'name' => 'Almoço',
            'value' => 25.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
