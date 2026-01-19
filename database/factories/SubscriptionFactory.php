<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Vendor;
use App\Models\PlanNutrition;
use App\Models\PaymentPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 month', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+6 months');
        $subtotal = fake()->randomFloat(2, 100, 1000);
        $discountAmount = fake()->randomFloat(2, 0, $subtotal * 0.3);
        $totalAmount = $subtotal - $discountAmount;

        return [
            'user_id' => User::factory(),
            'vendor_id' => Vendor::factory(),
            'nutrition_plan_id' => PlanNutrition::factory(),
            'payment_plan_id' => PaymentPlan::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'status' => fake()->randomElement(['pending', 'active', 'paused', 'cancelled', 'completed']),
        ];
    }

    /**
     * Indicate that the subscription is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the subscription is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the subscription is paused.
     */
    public function paused(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paused',
        ]);
    }

    /**
     * Indicate that the subscription is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }

    /**
     * Indicate that the subscription is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
}

