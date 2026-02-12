<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rent>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(3),
            'total_cost' => 100000,
            'payement_status' => 'En Attente',
            'payement_method' => 'Cash',
            'car_id' => Car::factory(),
            'user_id' => User::factory(),
        ];
    }
}
