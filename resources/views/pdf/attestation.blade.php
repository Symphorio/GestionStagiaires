<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attestation de stage</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
        }
        .content { 
            margin: 40px;
            text-align: justify;
        }
        .signature { 
            margin-top: 80px; 
            text-align: right;
        }
        ul {
            margin-top: 10px;
            padding-left: 20px;
        }
        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ATTESTATION DE STAGE</h1>
    </div>
    
    <div class="content">
        <p>Je soussigné(e), {{ $attestation->superviseur_name }}, certifie que :</p>
        
        <p><strong>{{ $attestation->rapport->stagiaire->prenom }} {{ $attestation->rapport->stagiaire->nom }}</strong></p>
        
        <p>a effectué un stage au sein de notre entreprise <strong>{{ $attestation->company_name }}</strong> située à {{ $attestation->company_address }}, du 
        {{ $attestation->rapport->created_at->format('d/m/Y') }} au {{ now()->format('d/m/Y') }}.</p>
        
        <p>Durant ce stage, le(la) stagiaire a réalisé les activités suivantes :</p>
        <ul>
            @if(is_array($attestation->activities) || is_object($attestation->activities))
                @forelse($attestation->activities as $activity)
                    <li>{{ $activity }}</li>
                @empty
                    <li>Aucune activité enregistrée</li>
                @endforelse
            @else
                <li>Les activités n'ont pas pu être chargées</li>
            @endif
        </ul>
        
        <p>Le(la) stagiaire a fait preuve de sérieux et de professionnalisme durant toute la durée de son stage.</p>
        
        <div class="signature">
            <p>Fait à {{ $attestation->company_address }}, le {{ now()->format('d/m/Y') }}</p>
            <p>Le superviseur de stage,</p>
            @if($attestation->signature_path)
                <img src="{{ storage_path('app/public/'.$attestation->signature_path) }}" width="150" style="margin-top: 20px;">
            @else
                <p style="margin-top: 50px;">_________________________</p>
            @endif
            <p>{{ $attestation->superviseur_name }}</p>
        </div>
    </div>
</body>
</html>