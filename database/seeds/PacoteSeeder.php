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
        DB::table('Pacote')->insert([
            'id' => 1,
            'nome' => 'Expotec',
            'valor' => 30.00,
            'dataLimite' => '2017-06-15',
            'dataLimite' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Pacote')->insert([
            'id' => 2,
            'nome' => 'Expotec + Almoço',
            'valor' => 50.00,
            'dataLimite' => '2017-06-15',
            'dataLimite' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Pacote')->insert([
            'id' => 3,
            'nome' => 'TADS',
            'valor' => 30.00,
            'dataLimite' => '2017-06-15',
            'dataLimite' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Pacote')->insert([
            'id' => 4,
            'nome' => 'TADS + Almoço',
            'valor' => 50.00,
            'dataLimite' => '2017-06-15',
            'dataLimite' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Pacote')->insert([
            'id' => 5,
            'nome' => 'Almoço',
            'valor' => 25.00,
            'dataLimite' => '2017-06-15',
            'dataLimite' => '2017-07-17',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
