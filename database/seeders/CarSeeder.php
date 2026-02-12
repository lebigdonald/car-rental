<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'make_year' => 2022,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 15.5,
                'fuel_type' => 'Essence',
                'transmission_type' => 'Automatique',
                'daily_rate' => 25000,
                'image_url' => 'https://images.unsplash.com/photo-1621007947382-bb3c3968e3bb?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'make_year' => 2021,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 14.0,
                'fuel_type' => 'Essence',
                'transmission_type' => 'Automatique',
                'daily_rate' => 22000,
                'image_url' => 'https://images.unsplash.com/photo-1606611013016-969c19ba27bb?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'BMW',
                'model' => 'X5',
                'make_year' => 2023,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 10.5,
                'fuel_type' => 'Diesel',
                'transmission_type' => 'Automatique',
                'daily_rate' => 60000,
                'image_url' => 'https://images.unsplash.com/photo-1556189250-72ba954522a0?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'make_year' => 2022,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 12.0,
                'fuel_type' => 'Essence',
                'transmission_type' => 'Automatique',
                'daily_rate' => 55000,
                'image_url' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Tesla',
                'model' => 'Model 3',
                'make_year' => 2023,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 0, // Electric
                'fuel_type' => 'Electric',
                'transmission_type' => 'Automatique',
                'daily_rate' => 45000,
                'image_url' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Ford',
                'model' => 'Mustang',
                'make_year' => 2020,
                'passenger_capacity' => 4,
                'kilometers_per_liter' => 8.5,
                'fuel_type' => 'Essence',
                'transmission_type' => 'manuel',
                'daily_rate' => 40000,
                'image_url' => 'https://images.unsplash.com/photo-1584345604476-8ec5e12e42dd?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Hyundai',
                'model' => 'Tucson',
                'make_year' => 2021,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 13.0,
                'fuel_type' => 'hybrid',
                'transmission_type' => 'Automatique',
                'daily_rate' => 30000,
                'image_url' => 'https://images.unsplash.com/photo-1626077388041-33311f8560f7?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Audi',
                'model' => 'A4',
                'make_year' => 2022,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 13.5,
                'fuel_type' => 'Diesel',
                'transmission_type' => 'Automatique',
                'daily_rate' => 50000,
                'image_url' => 'https://images.unsplash.com/photo-1606152421811-aa660061e7e4?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'make_year' => 2020,
                'passenger_capacity' => 5,
                'kilometers_per_liter' => 16.0,
                'fuel_type' => 'Essence',
                'transmission_type' => 'manuel',
                'daily_rate' => 20000,
                'image_url' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'brand' => 'Jeep',
                'model' => 'Wrangler',
                'make_year' => 2021,
                'passenger_capacity' => 4,
                'kilometers_per_liter' => 9.0,
                'fuel_type' => 'Essence',
                'transmission_type' => 'Automatique',
                'daily_rate' => 48000,
                'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($cars as $carData) {
            $car = Car::create(array_merge($carData, ['available' => true]));
            // Add 2 secondary images for each car
            Image::create([
                'car_id' => $car->id,
                'url' => 'https://source.unsplash.com/random/800x600/?car,interior',
            ]);
            Image::create([
                'car_id' => $car->id,
                'url' => 'https://source.unsplash.com/random/800x600/?car,wheel',
            ]);
        }
    }
}
