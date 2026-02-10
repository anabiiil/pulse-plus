<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Project Information
            [
                'title' => [
                    'en' => 'Project Title',
                    'ar' => 'عنوان المشروع',
                ],
                'slug' => 'project_title',
                'content' => [
                    'en' => 'Pulse - Healthcare Management System',
                    'ar' => 'بالس - نظام إدارة الرعاية الصحية',
                ],
            ],

            // Contact Information
            [
                'title' => [
                    'en' => 'Phone Number',
                    'ar' => 'رقم الهاتف',
                ],
                'slug' => 'phone',
                'content' => [
                    'en' => '+966 123 456 789',
                    'ar' => '+966 123 456 789',
                ],
            ],
            [
                'title' => [
                    'en' => 'WhatsApp Number',
                    'ar' => 'رقم الواتساب',
                ],
                'slug' => 'whatsapp',
                'content' => [
                    'en' => '+966 123 456 789',
                    'ar' => '+966 123 456 789',
                ],
            ],
            [
                'title' => [
                    'en' => 'Email Address',
                    'ar' => 'البريد الإلكتروني',
                ],
                'slug' => 'email',
                'content' => [
                    'en' => 'contact@pulse.com',
                    'ar' => 'contact@pulse.com',
                ],
            ],

            // Social Media Links
            [
                'title' => [
                    'en' => 'Instagram Link',
                    'ar' => 'رابط انستجرام',
                ],
                'slug' => 'instagram',
                'content' => [
                    'en' => 'https://instagram.com/pulse',
                    'ar' => 'https://instagram.com/pulse',
                ],
            ],
            [
                'title' => [
                    'en' => 'Facebook Link',
                    'ar' => 'رابط فيسبوك',
                ],
                'slug' => 'facebook',
                'content' => [
                    'en' => 'https://facebook.com/pulse',
                    'ar' => 'https://facebook.com/pulse',
                ],
            ],
            [
                'title' => [
                    'en' => 'Twitter Link',
                    'ar' => 'رابط تويتر',
                ],
                'slug' => 'twitter',
                'content' => [
                    'en' => 'https://twitter.com/pulse',
                    'ar' => 'https://twitter.com/pulse',
                ],
            ],
            [
                'title' => [
                    'en' => 'TikTok Link',
                    'ar' => 'رابط تيك توك',
                ],
                'slug' => 'tiktok',
                'content' => [
                    'en' => 'https://tiktok.com/@pulse',
                    'ar' => 'https://tiktok.com/@pulse',
                ],
            ],

            // Footer and Legal Content
            [
                'title' => [
                    'en' => 'Footer Content',
                    'ar' => 'محتوى التذييل',
                ],
                'slug' => 'footer_content',
                'content' => [
                    'en' => 'Pulse - Your trusted partner in healthcare management. Providing innovative solutions for medical professionals and patients since 2024.',
                    'ar' => 'بالس - شريكك الموثوق في إدارة الرعاية الصحية. نقدم حلول مبتكرة للمتخصصين الطبيين والمرضى منذ عام 2024.',
                ],
            ],
            [
                'title' => [
                    'en' => 'Privacy Policy',
                    'ar' => 'سياسة الخصوصية',
                ],
                'slug' => 'privacy',
                'content' => [
                    'en' => 'Privacy Policy

We at Pulse are committed to protecting your privacy and ensuring the security of your personal information. This privacy policy outlines how we collect, use, and safeguard your data.

Information We Collect:
- Personal identification information (name, email, phone number)
- Medical information (with your consent)
- Usage data and analytics

How We Use Your Information:
- To provide and improve our services
- To communicate with you about your account
- To ensure the security of our platform
- To comply with legal obligations

Data Security:
We implement industry-standard security measures to protect your personal information from unauthorized access, disclosure, or destruction.

Your Rights:
You have the right to access, update, or delete your personal information at any time.

For questions about our privacy policy, please contact us at privacy@pulse.com',
                    'ar' => 'سياسة الخصوصية

نحن في بالس ملتزمون بحماية خصوصيتك وضمان أمان معلوماتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع بياناتك واستخدامها وحمايتها.

المعلومات التي نجمعها:
- معلومات التعريف الشخصية (الاسم، البريد الإلكتروني، رقم الهاتف)
- المعلومات الطبية (بموافقتك)
- بيانات الاستخدام والتحليلات

كيف نستخدم معلوماتك:
- لتقديم خدماتنا وتحسينها
- للتواصل معك بشأن حسابك
- لضمان أمان منصتنا
- للامتثال للالتزامات القانونية

أمان البيانات:
نطبق تدابير أمنية متوافقة مع معايير الصناعة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو الكشف أو التدمير.

حقوقك:
لديك الحق في الوصول إلى معلوماتك الشخصية أو تحديثها أو حذفها في أي وقت.

للاستفسارات حول سياسة الخصوصية، يرجى الاتصال بنا على privacy@pulse.com',
                ],
            ],
            [
                'title' => [
                    'en' => 'Terms and Conditions',
                    'ar' => 'الشروط والأحكام',
                ],
                'slug' => 'terms_and_conditions',
                'content' => [
                    'en' => 'Terms and Conditions

Welcome to Pulse. By accessing or using our services, you agree to be bound by these Terms and Conditions.

1. Acceptance of Terms
By using our platform, you acknowledge that you have read, understood, and agree to be bound by these terms.

2. Use of Services
- You must be at least 18 years old to use our services
- You are responsible for maintaining the confidentiality of your account
- You agree to provide accurate and complete information

3. Medical Disclaimer
The information provided on our platform is for informational purposes only and should not replace professional medical advice.

4. Privacy
Your use of our services is also governed by our Privacy Policy.

5. Intellectual Property
All content on our platform is the property of Pulse and is protected by copyright laws.

6. Limitation of Liability
Pulse shall not be liable for any indirect, incidental, or consequential damages arising from your use of our services.

7. Changes to Terms
We reserve the right to modify these terms at any time. Continued use of our services constitutes acceptance of modified terms.

8. Contact Information
For questions about these terms, contact us at legal@pulse.com

Last Updated: February 2026',
                    'ar' => 'الشروط والأحكام

مرحباً بك في بالس. من خلال الوصول إلى خدماتنا أو استخدامها، فإنك توافق على الالتزام بهذه الشروط والأحكام.

1. قبول الشروط
باستخدام منصتنا، فإنك تقر بأنك قد قرأت وفهمت ووافقت على الالتزام بهذه الشروط.

2. استخدام الخدمات
- يجب أن يكون عمرك 18 عامًا على الأقل لاستخدام خدماتنا
- أنت مسؤول عن الحفاظ على سرية حسابك
- توافق على تقديم معلومات دقيقة وكاملة

3. إخلاء المسؤولية الطبية
المعلومات المقدمة على منصتنا هي لأغراض إعلامية فقط ولا ينبغي أن تحل محل المشورة الطبية المهنية.

4. الخصوصية
يخضع استخدامك لخدماتنا أيضًا لسياسة الخصوصية الخاصة بنا.

5. الملكية الفكرية
جميع المحتويات على منصتنا هي ملك لبالس ومحمية بموجب قوانين حقوق النشر.

6. تحديد المسؤولية
لن تكون بالس مسؤولة عن أي أضرار غير مباشرة أو عرضية أو تبعية ناشئة عن استخدامك لخدماتنا.

7. التغييرات على الشروط
نحتفظ بالحق في تعديل هذه الشروط في أي وقت. يشكل الاستمرار في استخدام خدماتنا قبولًا للشروط المعدلة.

8. معلومات الاتصال
للاستفسارات حول هذه الشروط، اتصل بنا على legal@pulse.com

آخر تحديث: فبراير 2026',
                ],
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['slug' => $setting['slug']],
                $setting
            );
        }
    }
}
