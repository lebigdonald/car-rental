<!DOCTYPE html>
<html>
<head>
    <title>Location Rejetée</title>
</head>
<body>
    <h1>Bonjour {{ $rent->user->first_name }},</h1>
    <p>Nous sommes désolés de vous informer que votre demande de location pour la voiture <strong>{{ $rent->car->brand }} {{ $rent->car->model }}</strong> a été rejetée.</p>
    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
    <p>Merci de votre compréhension.</p>
</body>
</html>
