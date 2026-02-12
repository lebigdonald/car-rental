<?php

namespace Tests\Unit;

use App\Models\Car;
use App\Models\Rent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    public function test_available_scope_excludes_rented_cars()
    {
        // Create a car
        $car = Car::factory()->create();

        // Create an active rental for this car
        Rent::factory()->create([
            'car_id' => $car->id,
            'start_date' => now()->subDay(),
            'end_date' => now()->addDay(),
            'payement_status' => 'Payé',
        ]);

        // Create another car with no rentals
        $availableCar = Car::factory()->create();

        // Check availability
        $availableCars = Car::available()->get();

        $this->assertFalse($availableCars->contains($car));
        $this->assertTrue($availableCars->contains($availableCar));
    }

    public function test_available_scope_includes_cars_with_past_rentals()
    {
        $car = Car::factory()->create();

        // Create a past rental
        Rent::factory()->create([
            'car_id' => $car->id,
            'start_date' => now()->subDays(5),
            'end_date' => now()->subDays(2),
            'payement_status' => 'Payé',
        ]);

        $availableCars = Car::available()->get();

        $this->assertTrue($availableCars->contains($car));
    }

    public function test_available_scope_includes_cars_with_future_rentals()
    {
        // Note: The current implementation of scopeAvailable checks if NOW is between start and end.
        // So a car with a future rental IS available right now.

        $car = Car::factory()->create();

        // Create a future rental
        Rent::factory()->create([
            'car_id' => $car->id,
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(5),
            'payement_status' => 'Payé',
        ]);

        $availableCars = Car::available()->get();

        $this->assertTrue($availableCars->contains($car));
    }
}
