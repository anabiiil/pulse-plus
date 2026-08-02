<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Seeder;

class GovernorateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            ['id' => 1, 'name' => ['ar' => 'القاهرة', 'en' => 'Cairo'], 'status' => 1],
            ['id' => 2, 'name' => ['ar' => 'الجيزة', 'en' => 'Giza'], 'status' => 1],
            ['id' => 3, 'name' => ['ar' => 'الإسكندرية', 'en' => 'Alexandria'], 'status' => 1],
            ['id' => 4, 'name' => ['ar' => 'الدقهلية', 'en' => 'Dakahlia'], 'status' => 1],
            ['id' => 5, 'name' => ['ar' => 'البحر الأحمر', 'en' => 'Red Sea'], 'status' => 1],
            ['id' => 6, 'name' => ['ar' => 'البحيرة', 'en' => 'Beheira'], 'status' => 1],
            ['id' => 7, 'name' => ['ar' => 'الفيوم', 'en' => 'Faiyum'], 'status' => 1],
            ['id' => 8, 'name' => ['ar' => 'الغربية', 'en' => 'Gharbia'], 'status' => 1],
            ['id' => 9, 'name' => ['ar' => 'الإسماعيلية', 'en' => 'Ismailia'], 'status' => 1],
            ['id' => 10, 'name' => ['ar' => 'المنوفية', 'en' => 'Monufia'], 'status' => 1],
            ['id' => 11, 'name' => ['ar' => 'المنيا', 'en' => 'Minya'], 'status' => 1],
            ['id' => 12, 'name' => ['ar' => 'القليوبية', 'en' => 'Qalyubia'], 'status' => 1],
            ['id' => 13, 'name' => ['ar' => 'الوادي الجديد', 'en' => 'New Valley'], 'status' => 1],
            ['id' => 14, 'name' => ['ar' => 'السويس', 'en' => 'Suez'], 'status' => 1],
            ['id' => 15, 'name' => ['ar' => 'أسوان', 'en' => 'Aswan'], 'status' => 1],
            ['id' => 16, 'name' => ['ar' => 'أسيوط', 'en' => 'Asyut'], 'status' => 1],
            ['id' => 17, 'name' => ['ar' => 'بني سويف', 'en' => 'Beni Suef'], 'status' => 1],
            ['id' => 18, 'name' => ['ar' => 'بورسعيد', 'en' => 'Port Said'], 'status' => 1],
            ['id' => 19, 'name' => ['ar' => 'دمياط', 'en' => 'Damietta'], 'status' => 1],
            ['id' => 20, 'name' => ['ar' => 'الشرقية', 'en' => 'Sharqia'], 'status' => 1],
            ['id' => 21, 'name' => ['ar' => 'جنوب سيناء', 'en' => 'South Sinai'], 'status' => 1],
            ['id' => 22, 'name' => ['ar' => 'كفر الشيخ', 'en' => 'Kafr El Sheikh'], 'status' => 1],
            ['id' => 23, 'name' => ['ar' => 'مطروح', 'en' => 'Matrouh'], 'status' => 1],
            ['id' => 24, 'name' => ['ar' => 'الأقصر', 'en' => 'Luxor'], 'status' => 1],
            ['id' => 25, 'name' => ['ar' => 'قنا', 'en' => 'Qena'], 'status' => 1],
            ['id' => 26, 'name' => ['ar' => 'شمال سيناء', 'en' => 'North Sinai'], 'status' => 1],
            ['id' => 27, 'name' => ['ar' => 'سوهاج', 'en' => 'Sohag'], 'status' => 1],
        ];

        foreach ($governorates as $governorate) {
            Governorate::updateOrCreate(
                ['id' => $governorate['id']],
                $governorate
            );
        }

        $this->command->info('Governorates seeded successfully!');
        $this->command->info('Total governorates: '.Governorate::count());
    }
}
