@extends('emails.layout')

@section('title', 'Location Rejetée')

@section('content')
    <h2>Bonjour {{ $rent->user->first_name }},</h2>
    <p>Nous sommes désolés de vous informer que votre demande de location pour la voiture
        <strong>{{ $rent->car->brand }} {{ $rent->car->model }}</strong> a été rejetée.</p>

    <p>Cela peut être dû à une indisponibilité imprévue du véhicule ou à d'autres raisons administratives.</p>

    <p>Nous vous invitons à consulter notre catalogue pour trouver un autre véhicule qui pourrait vous convenir.</p>

    <a href="{{ route('car.index') }}" class="btn">Voir les voitures disponibles</a>

    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
@endsection
