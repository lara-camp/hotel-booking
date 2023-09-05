<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $letter = $this->faker->randomLetter();
        $number = $this->faker->numberBetween(10, 99);
        return [
            'room_number' => $letter . $number,
            'room_type_id' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(40000, 80000),
        ];
    }
}
