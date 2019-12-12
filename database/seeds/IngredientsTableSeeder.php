<?php

use Illuminate\Database\Seeder;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ingredients')->insert([
            'name' => "Subheading",
            'yield_percent' => 1,
            'cost_per_unit' => 0,
            'unit_id' => 1                                 
            ]);
        DB::table('ingredients')->insert([
            'name' => "Water",
            'yield_percent' => 1,
            'cost_per_unit' => 0,
            'unit_id' => 3                                 
            ]);
    }
}
