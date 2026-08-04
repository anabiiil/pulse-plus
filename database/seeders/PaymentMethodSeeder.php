<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds the two system payment methods that cannot be deleted and whose
     * name cannot be edited (only description / image / active state can change).
     */
    public function run(): void
    {
        $methods = [
            [
                'code' => 'online',
                'name' => ['ar' => 'الدفع أونلاين', 'en' => 'Online Payment'],
                'description' => ['ar' => 'ادفع بأمان عبر الإنترنت باستخدام بطاقتك.', 'en' => 'Pay securely online with your card.'],
                'sort_order' => 1,
            ],
            [
                'code' => 'cod',
                'name' => ['ar' => 'الدفع عند الاستلام', 'en' => 'Cash on Delivery'],
                'description' => ['ar' => 'ادفع نقداً عند استلام طلبك.', 'en' => 'Pay cash when your order arrives.'],
                'sort_order' => 2,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                array_merge($method, ['is_system' => true, 'is_active' => true])
            );
        }

        $this->command->info('Payment methods seeded successfully!');
    }
}
