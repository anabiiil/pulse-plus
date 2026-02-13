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
        $countries = [
            ['id' => 1, 'name' => ['ar' => 'مصري', 'en' => 'Egyptian'], 'status' => 1],
            ['id' => 2, 'name' => ['ar' => 'سعودي', 'en' => 'Saudi'], 'status' => 1],
            ['id' => 3, 'name' => ['ar' => 'إماراتي', 'en' => 'Emirati'], 'status' => 1],
            ['id' => 4, 'name' => ['ar' => 'كويتي', 'en' => 'Kuwaiti'], 'status' => 1],
            ['id' => 5, 'name' => ['ar' => 'قطري', 'en' => 'Qatari'], 'status' => 1],
            ['id' => 6, 'name' => ['ar' => 'بحريني', 'en' => 'Bahraini'], 'status' => 1],
            ['id' => 7, 'name' => ['ar' => 'عماني', 'en' => 'Omani'], 'status' => 1],
            ['id' => 8, 'name' => ['ar' => 'أردني', 'en' => 'Jordanian'], 'status' => 1],
            ['id' => 9, 'name' => ['ar' => 'لبناني', 'en' => 'Lebanese'], 'status' => 1],
            ['id' => 10, 'name' => ['ar' => 'سوري', 'en' => 'Syrian'], 'status' => 1],
            ['id' => 11, 'name' => ['ar' => 'عراقي', 'en' => 'Iraqi'], 'status' => 1],
            ['id' => 12, 'name' => ['ar' => 'فلسطيني', 'en' => 'Palestinian'], 'status' => 1],
            ['id' => 13, 'name' => ['ar' => 'مغربي', 'en' => 'Moroccan'], 'status' => 1],
            ['id' => 14, 'name' => ['ar' => 'جزائري', 'en' => 'Algerian'], 'status' => 1],
            ['id' => 15, 'name' => ['ar' => 'تونسي', 'en' => 'Tunisian'], 'status' => 1],
            ['id' => 16, 'name' => ['ar' => 'ليبي', 'en' => 'Libyan'], 'status' => 1],
            ['id' => 17, 'name' => ['ar' => 'سوداني', 'en' => 'Sudanese'], 'status' => 1],
            ['id' => 18, 'name' => ['ar' => 'يمني', 'en' => 'Yemeni'], 'status' => 1],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['id' => $country['id']],
                $country
            );
        }

        $this->command->info('Countries seeded successfully!');
        $this->command->info('Total countries: ' . Country::count());
    }
}
