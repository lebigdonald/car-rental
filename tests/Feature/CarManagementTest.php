<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CarManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_car()
    {
        Storage::fake('public');
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $file = UploadedFile::fake()->image('car.jpg');

        $response = $this->post('/admin/voitures/create', [
            'model' => 'Model S',
            'brand' => 'Tesla',
            'make_year' => 2023,
            'passenger_capacity' => 5,
            'kilometers_per_liter' => 0, // Electric
            'fuel_type' => 'Electrique',
            'transmission_type' => 'Automatique',
            'daily_rate' => 50000,
            'main_image' => $file,
        ]);

        $response->assertRedirect(route('admin.car.index'));
        $this->assertDatabaseHas('cars', [
            'model' => 'Model S',
            'brand' => 'Tesla',
        ]);
        Storage::disk('public')->assertExists('car_images/' . $file->hashName());
    }

    public function test_admin_can_update_car()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $car = Car::factory()->create();

        $response = $this->put("/admin/voitures/edit/{$car->id}", [
            'model' => 'Updated Model',
            'brand' => $car->brand,
            'make_year' => $car->make_year,
            'passenger_capacity' => $car->passenger_capacity,
            'kilometers_per_liter' => $car->kilometers_per_liter,
            'fuel_type' => $car->fuel_type,
            'transmission_type' => $car->transmission_type,
            'daily_rate' => $car->daily_rate,
        ]);

        $response->assertRedirect(route('admin.car.index'));
        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'model' => 'Updated Model',
        ]);
    }

    public function test_admin_can_delete_car()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $car = Car::factory()->create();

        $response = $this->delete("/admin/voitures/delete/{$car->id}");

        $response->assertRedirect(route('admin.car.index'));
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}
