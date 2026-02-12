<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Car;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RentalProcessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_rental_request()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $car = Car::factory()->create(['daily_rate' => 10000]);

        $response = $this->post("/voitures/{$car->id}/louer", [
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'payement_method' => 'Cash',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('rents', [
            'user_id' => $user->id,
            'car_id' => $car->id,
            'payement_status' => 'En Attente',
        ]);
    }

    public function test_admin_can_approve_rental()
    {
        Mail::fake();
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $rent = Rent::factory()->create(['payement_status' => 'En Attente']);

        $response = $this->post("/admin/locations/approve/{$rent->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('rents', [
            'id' => $rent->id,
            'payement_status' => 'Payé',
        ]);
    }

    public function test_admin_can_reject_rental()
    {
        Mail::fake();
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $rent = Rent::factory()->create(['payement_status' => 'En Attente']);

        $response = $this->post("/admin/locations/reject/{$rent->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('rents', [
            'id' => $rent->id,
            'payement_status' => 'Annulé',
        ]);
    }
}
