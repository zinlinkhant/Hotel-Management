<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'age' => $this->faker->numberBetween(18, 80),
            'phone' => $this->faker->unique()->phoneNumber,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'points' => $this->faker->numberBetween(0, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
