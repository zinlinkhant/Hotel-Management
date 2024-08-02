<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numberBetween(1, 1000),
            'price' => $this->faker->numberBetween(50, 500),
            'name' => $this->faker->word,
            'num_of_people' => $this->faker->numberBetween(1, 4),
            'active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
