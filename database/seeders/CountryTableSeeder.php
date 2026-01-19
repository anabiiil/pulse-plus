<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('countries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Country::create([
            'name' =>
                [
                    'en' => 'Saudi Arabia'
                ],
        ]);

        Country::create([
            'name' =>
                [
                    'en' => 'Egypt'
                ],
        ]);
    }
}
