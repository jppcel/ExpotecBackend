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
            'name' => 'TADS',
            'value' => 30.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 4,
            'name' => 'TADS + Almoço',
            'value' => 50.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Package')->insert([
            'id' => 5,
            'name' => 'Almoço',
            'value' => 25.00,
            'startDate' => '2017-06-15',
            'endDate' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
