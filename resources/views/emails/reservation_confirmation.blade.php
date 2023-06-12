<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Réservation confirmée</title>
</head>
<body>
<h1>Réservation confirmée</h1>
<p>Votre réservation a été confirmée avec succès.</p>
<p>Détails de la réservation :</p>
<ul>
    <li>Événement : {{ $reservation->getEventName() }}</li>
    <li>Utilisateur : {{ $reservation->getUser()->getName() }}</li>
    <li>Nombre de billets : {{ $reservation->getTicketCount() }}</li>
</ul>
</body>
</html>
