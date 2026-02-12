@php use Carbon\Carbon; @endphp
@extends('emails.layout')

@section('title', 'Location Approuvée')

@section('content')
    <h2>Bonjour {{ $rent->user->first_name }},</h2>
    <p>Bonne nouvelle ! Votre demande de location pour la voiture
        <strong>{{ $rent->car->brand }} {{ $rent->car->model }}</strong> a été approuvée.</p>

    <h3>Détails de la location :</h3>
    <ul class="info-list">
        <li><strong>Date de début :</strong> {{ Carbon::parse($rent->start_date)->format('d/m/Y') }}</li>
        <li><strong>Date de fin :</strong> {{ Carbon::parse($rent->end_date)->format('d/m/Y') }}</li>
        <li><strong>Coût total :</strong> {{ number_format($rent->total_cost, 0, ',', ' ') }} FCFA</li>
    </ul>

    <p>Vous pouvez maintenant profiter de votre véhicule. Si vous avez des questions, n'hésitez pas à nous
        contacter.</p>

    <p>Merci de faire confiance à CarRental !</p>

    <a href="{{ route('rent.index') }}" class="btn">Voir mes locations</a>
@endsection
