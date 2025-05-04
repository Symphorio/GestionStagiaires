<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de demande de stage</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Confirmation de demande de stage</h1>
    
    <p>Votre demande de stage a été approuvée !</p>
    
    <p><strong>Détails :</strong></p>
    <ul>
        <li>Nom: {{ $demande->prenom }} {{ $demande->nom }}</li>
        <li>Email: {{ $demande->email }}</li>
        <li>Code d'inscription: <strong>{{ $internCode }}</strong></li>
    </ul>

    <p>Pour créer votre compte, utilisez :</p>
    <ul>
        <li>Cet email exact: {{ $demande->email }}</li>
        <li>Le code fourni ci-dessus</li>
    </ul>

    <a href="{{ route('stagiaire.register.form') }}" class="button">
        Créer mon compte stagiaire
    </a>

    <p>Merci,<br>
    {{ config('app.name') }}</p>
</body>
</html>