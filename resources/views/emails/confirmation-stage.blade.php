{{-- resources/views/emails/confirmation-stage.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de demande de stage</title>
</head>
<body>
    <h1>Votre demande de stage a été approuvée</h1>
    
    <p>Bonjour {{ $demande->prenom }},</p>
    
    <p>Nous avons le plaisir de vous informer que votre demande de stage a été approuvée et signée électroniquement.</p>
    
    <p><strong>Détails :</strong></p>
    <ul>
        <li>Période : du {{ $demande->date_debut->format('d/m/Y') }} au {{ $demande->date_fin->format('d/m/Y') }}</li>
        <li>Formation : {{ $demande->formation }}</li>
        <li>Date d'approbation : {{ $demande->authorized_at->format('d/m/Y H:i') }}</li>
    </ul>
    
    @if($demande->signature_data)
    <p>
        <strong>Signature électronique :</strong><br>
        <img src="{{ $message->embed(storage_path('app/public/'.$demande->signature_data)) }}" 
             alt="Signature électronique" style="max-width: 300px;">
    </p>
    @endif
    
    <p>Cordialement,<br>L'équipe DPAF</p>
</body>
</html>