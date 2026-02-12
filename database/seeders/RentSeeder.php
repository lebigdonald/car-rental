<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $cars = Car::all();

        if ($users->isEmpty() || $cars->isEmpty()) {
            return;
        }

        // Create some past rentals (completed)
        for ($i = 0; $i < 20; $i++) {
            $car = $cars->random();
            $user = $users->random();
            $startDate = now()->subDays(rand(10, 100));
            $endDate = $startDate->copy()->addDays(rand(1, 7));
            $days = $endDate->diffInDays($startDate) ?: 1;

            Rent::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_cost' => $days * $car->daily_rate,
                'payement_status' => 'payé',
                'payement_method' => 'Carte bancaire',
            ]);
        }

        // Create some active/future rentals
        for ($i = 0; $i < 10; $i++) {
            $car = $cars->random();
            $user = $users->random();
            $startDate = now()->addDays(rand(1, 30));
            $endDate = $startDate->copy()->addDays(rand(1, 7));
            $days = $endDate->diffInDays($startDate) ?: 1;

            // Check basic availability (simplified for seeder)
            $exists = Rent::where('car_id', $car->id)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate]);
                })->exists();

            if (!$exists) {
                Rent::create([
                    'user_id' => $user->id,
                    'car_id' => $car->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_cost' => $days * $car->daily_rate,
                    'payement_status' => 'en attente',
                    'payement_method' => 'Mobile Money',
                ]);
            }
        }
    }
}
