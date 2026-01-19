<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanNutrition>
 */
class PlanNutritionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate ranges within the specified limits
        $proteinMin = fake()->numberBetween(10, 15);
        $proteinMax = fake()->numberBetween($proteinMin, 20);

        $carbMin = fake()->numberBetween(20, 30);
        $carbMax = fake()->numberBetween($carbMin, 40);

        $fatsMin = fake()->numberBetween(15, 17);
        $fatsMax = fake()->numberBetween($fatsMin, 20);

        return [
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl(640, 480, 'food', true, 'nutrition'),
            'protein_percentage' => "{$proteinMin}-{$proteinMax}",
            'carb_percentage' => "{$carbMin}-{$carbMax}",
            'fats_percentage' => "{$fatsMin}-{$fatsMax}",
            'agency_id' => Agency::factory(),
            'is_active' => fake()->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Indicate that the plan nutrition is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the plan nutrition is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
