@extends('emails.layout')

@section('title', 'Nouveau message de contact')

@section('content')
    <h2>Nouveau message de contact</h2>
    <p>Vous avez reçu un nouveau message via le formulaire de contact.</p>

    <ul class="info-list">
        <li><strong>Nom :</strong> {{ $data['name'] }}</li>
        <li><strong>Email :</strong> {{ $data['email'] }}</li>
        <li><strong>Sujet :</strong> {{ $data['subject'] }}</li>
    </ul>

    <h3>Message :</h3>
    <p style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #2F80ED;">
        {{ $data['message'] }}
    </p>
@endsection
