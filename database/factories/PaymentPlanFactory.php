<?php

namespace Database\Factories;

use App\Models\PaymentPlan;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PaymentPlan>
 */
class PaymentPlanFactory extends Factory
{
    protected $model = PaymentPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement(['Weekly', 'Monthly', 'Quarterly', 'Semi-Annual', 'Annual']);
        $daysMap = [
            'Weekly' => 7,
            'Monthly' => 30,
            'Quarterly' => 90,
            'Semi-Annual' => 180,
            'Annual' => 365,
        ];

        return [
            'vendor_id' => Vendor::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'days' => $daysMap[$name],
            'discount_percentage' => fake()->randomFloat(2, 0, 25),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => fake()->boolean(90),
        ];
    }

    /**
     * Indicate that the payment plan is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the payment plan is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}

