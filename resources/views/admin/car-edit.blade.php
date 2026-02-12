@extends('admin.layouts.master')

@section('title', "Modifier une voiture")

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Modifier une voiture</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.car.index') }}">Voitures</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>

        <div class="mb-4">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <div>
                    {{ $error }}
                </div>
            </div>
            @endforeach
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.car.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="model" class="col-sm-3 my-2 col-form-label">Modèle :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $car->model) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="brand" class="col-sm-3 my-2 col-form-label">Marque :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $car->brand) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="year" class="col-sm-3 my-2 col-form-label">Année de fabrication :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="year" name="make_year" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('make_year', $car->make_year) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="seats" class="col-sm-3 my-2 col-form-label">Nombre de sièges :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="seats" name="passenger_capacity" min="1" max="50" value="{{ old('passenger_capacity', $car->passenger_capacity) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="km_per_litre" class="col-sm-3 my-2 col-form-label">Kilométrage par litre :</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="km_per_litre" name="kilometers_per_liter" step="0.01" value="{{ old('kilometers_per_liter', $car->kilometers_per_liter) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fuel_type" class="col-sm-3 my-2 col-form-label">Type de carburant :</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="fuel_type" name="fuel_type" required>
                                    <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                                    <option value="essence" {{ old('fuel_type', $car->fuel_type) == 'essence' ? 'selected' : '' }}>Essence</option>
                                    <option value="electric" {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>Électrique</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="transmission_type" class="col-sm-3 my-2 col-form-label">Type de transmission :</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="transmission_type" name="transmission_type" required>
                                    <option value="automatique" {{ old('transmission_type', $car->transmission_type) == 'automatique' ? 'selected' : '' }}>Automatique</option>
                                    <option value="manuel" {{ old('transmission_type', $car->transmission_type) == 'manuel' ? 'selected' : '' }}>Manuel</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rental_price" class="col-sm-3 my-2 col-form-label">Prix de location par jour :</label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="rental_price" name="daily_rate" step="0.01" value="{{ old('daily_rate', $car->daily_rate) }}" required> FCFA
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="main_image" class="col-sm-3 my-2 col-form-label">Image principale (laisser vide pour conserver) :</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control-file" id="main_image" name="main_image" accept="image/*">
                                <div id="main_image_preview"></div>
                                @if($car->image_url)
                                    <div class="mt-2">
                                        <p class="mb-1">Image actuelle :</p>
                                        <img src="{{ Storage::url($car->image_url) }}" alt="Current Image" style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="secondary_images" class="col-sm-3 my-2 col-form-label">Images secondaires (ajouter pour compléter) :</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control-file" id="secondary_images" name="secondary_images[]" accept="image/*" multiple>
                                <div id="secondary_images_preview" class="d-flex flex-wrap"></div>
                                @if($car->secondaryImages->count() > 0)
                                    <div class="mt-2">
                                        <p class="mb-1">Images actuelles :</p>
                                        <div class="d-flex flex-wrap">
                                            @foreach($car->secondaryImages as $image)
                                                <img src="{{ Storage::url($image->url) }}" alt="Secondary Image" style="max-height: 50px; margin-right: 5px;" class="img-thumbnail">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row my-4">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
