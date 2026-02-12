<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => fake()->word(),
            'brand' => fake()->word(),
            'make_year' => fake()->year(),
            'passenger_capacity' => fake()->numberBetween(2, 7),
            'kilometers_per_liter' => fake()->randomFloat(2, 5, 20),
            'fuel_type' => fake()->randomElement(['Diesel', 'Hybride', 'Essence', 'Electrique']),
            'transmission_type' => fake()->randomElement(['Automatique', 'Manuel']),
            'daily_rate' => fake()->randomFloat(2, 10000, 50000),
            'image_url' => 'car_images/default.jpg',
            'available' => true,
        ];
    }
}

