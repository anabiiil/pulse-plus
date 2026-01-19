<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admins')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '123456789',
            'password' => '11331133',
        ]);
    }
}
