<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * @var array<int, array{ar: string, en: string}>
     */
    private array $diseases = [
        ['ar' => 'السكري',                        'en' => 'Diabetes'],
        ['ar' => 'ارتفاع ضغط الدم',               'en' => 'Hypertension'],
        ['ar' => 'أمراض القلب التاجية',            'en' => 'Coronary Heart Disease'],
        ['ar' => 'الربو',                          'en' => 'Asthma'],
        ['ar' => 'الفشل الكلوي المزمن',            'en' => 'Chronic Kidney Disease'],
        ['ar' => 'قصور الغدة الدرقية',             'en' => 'Hypothyroidism'],
        ['ar' => 'فرط نشاط الغدة الدرقية',         'en' => 'Hyperthyroidism'],
        ['ar' => 'الأنيميا',                       'en' => 'Anemia'],
        ['ar' => 'الصرع',                          'en' => 'Epilepsy'],
        ['ar' => 'الروماتيزم',                     'en' => 'Rheumatism'],
        ['ar' => 'التهاب المفاصل',                 'en' => 'Arthritis'],
        ['ar' => 'الأكزيما',                       'en' => 'Eczema'],
        ['ar' => 'حساسية الغذاء',                  'en' => 'Food Allergy'],
        ['ar' => 'حساسية الأدوية',                 'en' => 'Drug Allergy'],
        ['ar' => 'حساسية اللاتكس',                 'en' => 'Latex Allergy'],
        ['ar' => 'الصدفية',                        'en' => 'Psoriasis'],
        ['ar' => 'قرحة المعدة',                    'en' => 'Peptic Ulcer'],
        ['ar' => 'القولون العصبي',                 'en' => 'Irritable Bowel Syndrome'],
        ['ar' => 'الكبد الدهني',                   'en' => 'Fatty Liver Disease'],
        ['ar' => 'التهاب الكبد الفيروسي',          'en' => 'Viral Hepatitis'],
        ['ar' => 'حصوات الكلى',                    'en' => 'Kidney Stones'],
        ['ar' => 'الجلطة الدماغية',                'en' => 'Stroke'],
        ['ar' => 'الذبحة الصدرية',                 'en' => 'Angina'],
        ['ar' => 'هشاشة العظام',                   'en' => 'Osteoporosis'],
        ['ar' => 'سرطان الثدي',                    'en' => 'Breast Cancer'],
        ['ar' => 'سرطان القولون',                  'en' => 'Colon Cancer'],
        ['ar' => 'الزهايمر',                       'en' => 'Alzheimer\'s Disease'],
        ['ar' => 'الشلل الرعاش (باركنسون)',        'en' => 'Parkinson\'s Disease'],
        ['ar' => 'التصلب المتعدد',                 'en' => 'Multiple Sclerosis'],
        ['ar' => 'الاكتئاب المزمن',                'en' => 'Chronic Depression'],
        ['ar' => 'القلق المزمن',                   'en' => 'Chronic Anxiety'],
        ['ar' => 'مرض كرون',                       'en' => 'Crohn\'s Disease'],
        ['ar' => 'التهاب القولون التقرحي',         'en' => 'Ulcerative Colitis'],
        ['ar' => 'متلازمة تكيس المبايض',           'en' => 'Polycystic Ovary Syndrome'],
        ['ar' => 'فقر الدم المنجلي',               'en' => 'Sickle Cell Anemia'],
        ['ar' => 'الثلاسيميا',                     'en' => 'Thalassemia'],
        ['ar' => 'الذئبة الحمراء',                 'en' => 'Lupus'],
        ['ar' => 'الانسداد الرئوي المزمن',         'en' => 'Chronic Obstructive Pulmonary Disease'],
        ['ar' => 'اضطراب فرط الحركة وتشتت الانتباه', 'en' => 'ADHD'],
        ['ar' => 'التوحد',                         'en' => 'Autism Spectrum Disorder'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->diseases as $disease) {
            Disease::firstOrCreate(
                ['name->ar' => $disease['ar']],
                ['name' => ['ar' => $disease['ar'], 'en' => $disease['en']]]
            );
        }
    }
}
