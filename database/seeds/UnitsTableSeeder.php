<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('units')->insert(['name' => "g"]);
        DB::table('units')->insert(['name' => "Kg"]);
        DB::table('units')->insert(['name' => "ml"]);
        DB::table('units')->insert(['name' => "L"]);
        DB::table('units')->insert(['name' => "ea"]);
        DB::table('units')->insert(['name' => "lb"]);
    }
}
