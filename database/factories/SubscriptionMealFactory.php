<?php

namespace Database\Factories;

use App\Models\SubscriptionMeal;
use App\Models\Subscription;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SubscriptionMeal>
 */
class SubscriptionMealFactory extends Factory
{
    protected $model = SubscriptionMeal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $basePrice = fake()->randomFloat(2, 10, 100);
        $finalPrice = $basePrice - fake()->randomFloat(2, 0, $basePrice * 0.2);

        return [
            'subscription_id' => Subscription::factory(),
            'meal_id' => Meal::factory(),
            'delivery_date' => fake()->dateTimeBetween('now', '+30 days'),
            'meal_type' => fake()->randomElement(['breakfast', 'lunch', 'dinner', 'snack']),
            'base_price' => $basePrice,
            'final_price' => $finalPrice,
            'status' => fake()->randomElement(['scheduled', 'prepared', 'out_for_delivery', 'delivered', 'cancelled']),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }

    /**
     * Indicate that the meal is scheduled.
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'scheduled',
        ]);
    }

    /**
     * Indicate that the meal is prepared.
     */
    public function prepared(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'prepared',
        ]);
    }

    /**
     * Indicate that the meal is out for delivery.
     */
    public function outForDelivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'out_for_delivery',
        ]);
    }

    /**
     * Indicate that the meal is delivered.
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
        ]);
    }

    /**
     * Indicate that the meal is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}

