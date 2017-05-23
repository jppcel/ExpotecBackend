<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TrilhaSeeder::class);
        $this->call(PacoteSeeder::class);
        $this->call(TrilhaPacoteSeeder::class);
        $this->call(SpeakerSeeder::class);
        $this->call(AtividadeSeeder::class);
    }
}
