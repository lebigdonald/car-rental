@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html>
<head>
    <title>Location Approuvée</title>
</head>
<body>
<h1>Bonjour {{ $rent->user->first_name }},</h1>
<p>Votre demande de location pour la voiture <strong>{{ $rent->car->brand }} {{ $rent->car->model }}</strong> a été
    approuvée.</p>
<p>Détails de la location :</p>
<ul>
    <li>Date de début : {{ Carbon::parse($rent->start_date)->format('d/m/Y') }}</li>
    <li>Date de fin : {{ Carbon::parse($rent->end_date)->format('d/m/Y') }}</li>
    <li>Coût total : {{ number_format($rent->total_cost, 0, ',', ' ') }} FCFA</li>
</ul>
<p>Merci de faire confiance à CarRental !</p>
</body>
</html>
