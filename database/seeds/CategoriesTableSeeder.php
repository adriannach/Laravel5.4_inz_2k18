<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
          'id' => 1,
          'name' => 'Baza',
        ]);

        DB::table('categories')->insert([
          'id' => 2,
          'name' => 'Statyka',
        ]);

        DB::table('categories')->insert([
          'id' => 3,
          'name' => 'Dynamika',
        ]);

        DB::table('categories')->insert([
          'id' => 4,
          'name' => 'Inne',
        ]);
    }
}
