@extends('admin.layouts.master')

@section('title', "Modifier location")

@section('main')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Modifier une location</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rent.index') }}">Locations</a></li>
                <li class="breadcrumb-item active">Modifier {{ $rent->id }}</li>
            </ol>

            <div class="mb-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Location #{{ $rent->id }} - {{ $rent->car->brand }} {{ $rent->car->model }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.rent.update', $rent->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group row mb-3">
                                <label for="start_date" class="col-sm-3 col-form-label">Date de début :</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                           value="{{ old('start_date', \Carbon\Carbon::parse($rent->start_date)->format('Y-m-d')) }}"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="end_date" class="col-sm-3 col-form-label">Date de fin :</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                           value="{{ old('end_date', \Carbon\Carbon::parse($rent->end_date)->format('Y-m-d')) }}"
                                           required>
                                </div>
                            </div>
                            {{--
                                                        <div class="form-group row mb-3">
                                                            <label for="payement_status" class="col-sm-3 col-form-label">Statut du paiement
                                                                :</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" id="payement_status" name="payement_status" required>
                                                                    <option
                                                                        value="En Attente" {{ old('payement_status', $rent->payement_status) == 'En Attente' ? 'selected' : '' }}>
                                                                        En attente
                                                                    </option>
                                                                    <option
                                                                        value="Payé" {{ old('payement_status', $rent->payement_status) == 'Payé' ? 'selected' : '' }}>
                                                                        Payé
                                                                    </option>
                                                                    <option
                                                                        value="Annulé" {{ old('payement_status', $rent->payement_status) == 'Annulé' ? 'selected' : '' }}>
                                                                        Annulé
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                            --}}
                            <div class="form-group row mb-3">
                                <label for="payement_method" class="col-sm-3 col-form-label">Méthode de paiement
                                    :</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="payement_method" name="payement_method" required>
                                        <option
                                            value="Cash" {{ old('payement_method', $rent->payement_method) == 'Cash' ? 'selected' : '' }}>
                                            Cash
                                        </option>
                                        <option
                                            value="Mobile" {{ old('payement_method', $rent->payement_method) == 'Mobile' ? 'selected' : '' }}>
                                            Mobile
                                        </option>
                                        <option
                                            value="Paypal" {{ old('payement_method', $rent->payement_method) == 'Paypal' ? 'selected' : '' }}>
                                            Paypal
                                        </option>
                                        <option
                                            value="Visa" {{ old('payement_method', $rent->payement_method) == 'Visa' ? 'selected' : '' }}>
                                            Visa
                                        </option>
                                        <option
                                            value="Mastercard" {{ old('payement_method', $rent->payement_method) == 'Mastercard' ? 'selected' : '' }}>
                                            Mastercard
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                    <a href="{{ route('admin.rent.index') }}" class="btn btn-secondary">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
