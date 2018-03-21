<?php

use Illuminate\Database\Seeder;

class CEPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ZIP')->insert([
          'TypeStreet_id' => 2,
          'City_id' => 3979,
          'name' => 'das Gardênias',
          'neighborhood' => 'Guarujá',
          'zipcode' => '85804460'
        ]);
        DB::table('ZIP')->insert([
          'TypeStreet_id' => 4,
          'City_id' => 3979,
          'name' => 'Tito Muffato',
          'neighborhood' => 'Santa Cruz',
          'zipcode' => '85806080'
        ]);
        DB::table('ZIP')->insert([
          'City_id' => 3979,
          'zipcode' => '85800000'
        ]);
    }
}
