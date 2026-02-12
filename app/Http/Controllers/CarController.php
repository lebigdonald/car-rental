<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarCreationRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Car;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $cars = Car::latest()->paginate(20);
            return view('admin.cars', compact('cars'));
        }

        $carsQuery = Car::available();

        // Filter by model
        if ($request->filled('model')) {
            $carsQuery->where('model', 'like', '%' . $request->input('model') . '%');
        }

        // Filter by max daily rate
        if ($request->filled('max_daily_rate')) {
            $carsQuery->where('daily_rate', '<=', $request->input('max_daily_rate'));
        }

        // Filter by make year
        if ($request->filled('make_year')) {
            $carsQuery->where('make_year', $request->input('make_year'));
        }

        if ($request->input('make_tmp') === 'nouveau') {
            $carsQuery->where('make_year', '>=', date('Y') - 2);
        } elseif ($request->input('make_tmp') === 'ancien') {
            $carsQuery->where('make_year', '<', date('Y') - 2);
        }

        // Filter by brand
        if ($request->filled('brand') && $request->input('brand') !== 'tout') {
            $carsQuery->where('brand', 'like', '%' . $request->input('brand') . '%');
        }

        // Sort by creation date
        if ($request->input('sort') === 'recent') {
            $carsQuery->orderByDesc('created_at');
        }

        $limit = $request->input('limit', 9);
        $cars = $carsQuery->paginate($limit);

        return view('cars', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.car-create');
        }
        return redirect()->route('car.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarCreationRequest $request)
    {
        $validatedData = $request->validated();

        $mainImage = $request->file('main_image');
        $imagePath = $mainImage->store('car_images', 'public');

        $car = Car::create(array_merge($validatedData, ['image_url' => $imagePath]));

        if ($request->hasFile('secondary_images')) {
            foreach ($request->file('secondary_images') as $secondaryImage) {
                $path = $secondaryImage->store('car_images', 'public');
                $car->secondaryImages()->create(['url' => $path]);
            }
        }

        return redirect()->route('admin.car.index')->with('success', 'La voiture a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::with('secondaryImages')->findOrFail($id);

        if (Auth::guard('admin')->check()) {
            return view('admin.car-details', compact('car'));
        }
        return view('car-details', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::with('secondaryImages')->findOrFail($id);

        if (Auth::guard('admin')->check()) {
            return view('admin.car-edit', compact('car'));
        }
        return redirect()->route('car.show', $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarUpdateRequest $request, string $id)
    {
        $car = Car::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('main_image')) {
            // Delete old image
            Storage::disk('public')->delete($car->image_url);
            $validatedData['image_url'] = $request->file('main_image')->store('car_images', 'public');
        }

        $car->update($validatedData);

        if ($request->hasFile('secondary_images')) {
            // Consider deleting old secondary images if that's the desired behavior
            foreach ($request->file('secondary_images') as $secondaryImage) {
                $path = $secondaryImage->store('car_images', 'public');
                $car->secondaryImages()->create(['url' => $path]);
            }
        }

        return redirect()->route('admin.car.index')->with('success', 'La voiture a été modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);

        // Delete main image
        Storage::disk('public')->delete($car->image_url);

        // Delete secondary images
        foreach ($car->secondaryImages as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }

        $car->delete();

        return redirect()->route('admin.car.index')->with('success', 'La voiture a été supprimée avec succès.');
    }
}
