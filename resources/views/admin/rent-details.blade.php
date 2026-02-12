@extends('admin.layouts.master')

@section('title', 'Détails de la location')

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Détails de la location #{{ $rent->id }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.rent.index') }}">Locations</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>

        <div class="row">
            <!-- Rental Details -->
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Informations sur la location
                    </div>
                    <div class="card-body">
                        <p><strong>Date de début:</strong> {{ \Carbon\Carbon::parse($rent->start_date)->format('d/m/Y') }}</p>
                        <p><strong>Date de fin:</strong> {{ \Carbon\Carbon::parse($rent->end_date)->format('d/m/Y') }}</p>
                        <p><strong>Coût total:</strong> {{ number_format($rent->total_cost, 0, ',', ' ') }} FCFA</p>
                        <p><strong>Méthode de paiement:</strong> {{ $rent->payement_method }}</p>
                        <p><strong>Statut du paiement:</strong>
                            @if($rent->payement_status == 'payé')
                                <span class="badge bg-success">Payé</span>
                            @elseif($rent->payement_status == 'en attente')
                                <span class="badge bg-warning text-dark">En attente</span>
                            @elseif($rent->payement_status == 'annulé')
                                <span class="badge bg-danger">Annulé</span>
                            @else
                                <span class="badge bg-secondary">{{ $rent->payement_status }}</span>
                            @endif
                        </p>

                        @if($rent->payement_status == 'en attente')
                        <div class="mt-3">
                            <h5>Actions</h5>
                            <form action="{{ route('admin.rent.approve', $rent->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Approuver (Marquer comme payé)</button>
                            </form>
                            <form action="{{ route('admin.rent.reject', $rent->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Rejeter</button>
                            </form>
                        </div>
                        @elseif($rent->payement_status == 'payé')
                        <div class="mt-3">
                            <a href="{{ route('admin.rent.invoice', ['id' => $rent->id]) }}" class="btn btn-primary" target="_blank">Voir la facture</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Details -->
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Informations sur l'utilisateur
                    </div>
                    <div class="card-body">
                        <p><strong>Nom:</strong> {{ $rent->user->first_name }} {{ $rent->user->last_name }}</p>
                        <p><strong>Email:</strong> {{ $rent->user->email }}</p>
                        <p><strong>Téléphone:</strong> {{ $rent->user->phone }}</p>
                        <a href="{{ route('admin.user.show', $rent->user->id) }}" class="btn btn-primary btn-sm">Voir le profil complet</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Car Details -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Informations sur la voiture
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ Storage::url($rent->car->image_url) }}" alt="Car Image" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <h5>{{ $rent->car->brand }} {{ $rent->car->model }}</h5>
                                <p><strong>Année:</strong> {{ $rent->car->make_year }}</p>
                                <p><strong>Capacité:</strong> {{ $rent->car->passenger_capacity }} personnes</p>
                                <p><strong>Carburant:</strong> {{ $rent->car->fuel_type }}</p>
                                <a href="{{ route('admin.car.show', $rent->car->id) }}" class="btn btn-primary btn-sm">Voir les détails de la voiture</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
