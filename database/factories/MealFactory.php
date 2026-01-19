<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Meal>
 */
class MealFactory extends Factory
{
    protected $model = Meal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'image' => null,
            'calories' => fake()->numberBetween(200, 800),
            'meal_type' => fake()->randomElement($mealTypes),
            'protein_amount' => fake()->randomFloat(2, 10, 50),
            'carb_amount' => fake()->randomFloat(2, 20, 80),
            'fat_amount' => fake()->randomFloat(2, 5, 30),
            'price' => fake()->randomFloat(2, 10, 100),
            'is_active' => fake()->boolean(80),
        ];
    }

    /**
     * Indicate that the meal is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the meal is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Set the meal type.
     */
    public function mealType(string $type): static
    {
        return $this->state(fn (array $attributes) => [
            'meal_type' => $type,
        ]);
    }
}

