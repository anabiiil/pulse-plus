<?php

namespace Database\Factories;

use App\Enums\VendorType;
use App\Models\Vendor;
use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Vendor>
 */
class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agency_id' => Agency::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'password' => Hash::make('password'),
            'status' => fake()->boolean(80),
            'type' => fake()->randomElement([VendorType::OWNER, VendorType::EMPLOYEE]),
            'locale' => fake()->randomElement(['ar', 'en']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the vendor is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => true,
        ]);
    }

    /**
     * Indicate that the vendor is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => false,
        ]);
    }

    /**
     * Indicate that the vendor is an owner.
     */
    public function owner(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => VendorType::OWNER,
        ]);
    }

    /**
     * Indicate that the vendor is an employee.
     */
    public function employee(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => VendorType::EMPLOYEE,
        ]);
    }
}

