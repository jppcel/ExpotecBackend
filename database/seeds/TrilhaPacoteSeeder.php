<?php

use Illuminate\Database\Seeder;

class TrilhaPacoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Trilha_Pacote')->insert([
            'Trilha_id' => 1,
            'Pacote_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Trilha_Pacote')->insert([
            'Trilha_id' => 1,
            'Pacote_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Trilha_Pacote')->insert([
            'Trilha_id' => 2,
            'Pacote_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Trilha_Pacote')->insert([
            'Trilha_id' => 2,
            'Pacote_id' => 4,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Trilha_Pacote')->insert([
            'Trilha_id' => 3,
            'Pacote_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Trilha_Pacote')->insert([
            'Trilha_id' => 3,
            'Pacote_id' => 4,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('Trilha_Pacote')->insert([
            'Trilha_id' => 3,
            'Pacote_id' => 5,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
