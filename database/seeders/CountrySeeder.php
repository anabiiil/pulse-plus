<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => ['ar' => 'مصر', 'en' => 'Egypt'],
                'iso3' => 'EGY',
                'phone_code' => '+20',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'السعودية', 'en' => 'Saudi Arabia'],
                'iso3' => 'SAU',
                'phone_code' => '+966',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'الإمارات', 'en' => 'United Arab Emirates'],
                'iso3' => 'ARE',
                'phone_code' => '+971',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'الكويت', 'en' => 'Kuwait'],
                'iso3' => 'KWT',
                'phone_code' => '+965',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'قطر', 'en' => 'Qatar'],
                'iso3' => 'QAT',
                'phone_code' => '+974',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'البحرين', 'en' => 'Bahrain'],
                'iso3' => 'BHR',
                'phone_code' => '+973',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'عمان', 'en' => 'Oman'],
                'iso3' => 'OMN',
                'phone_code' => '+968',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'الأردن', 'en' => 'Jordan'],
                'iso3' => 'JOR',
                'phone_code' => '+962',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'لبنان', 'en' => 'Lebanon'],
                'iso3' => 'LBN',
                'phone_code' => '+961',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'سوريا', 'en' => 'Syria'],
                'iso3' => 'SYR',
                'phone_code' => '+963',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'العراق', 'en' => 'Iraq'],
                'iso3' => 'IRQ',
                'phone_code' => '+964',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'فلسطين', 'en' => 'Palestine'],
                'iso3' => 'PSE',
                'phone_code' => '+970',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'المغرب', 'en' => 'Morocco'],
                'iso3' => 'MAR',
                'phone_code' => '+212',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'الجزائر', 'en' => 'Algeria'],
                'iso3' => 'DZA',
                'phone_code' => '+213',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'تونس', 'en' => 'Tunisia'],
                'iso3' => 'TUN',
                'phone_code' => '+216',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'ليبيا', 'en' => 'Libya'],
                'iso3' => 'LBY',
                'phone_code' => '+218',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'السودان', 'en' => 'Sudan'],
                'iso3' => 'SDN',
                'phone_code' => '+249',
                'status' => 1,
            ],
            [
                'name' => ['ar' => 'اليمن', 'en' => 'Yemen'],
                'iso3' => 'YEM',
                'phone_code' => '+967',
                'status' => 1,
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso3' => $country['iso3']],
                $country
            );
        }

        $this->command->info('Countries seeded successfully!');
        $this->command->info('Total countries: ' . Country::count());
    }
}

