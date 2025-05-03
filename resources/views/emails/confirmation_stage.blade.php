@component('mail::message')
# Confirmation de demande de stage

Votre demande de stage a été approuvée !

**Détails :**
- Nom: {{ $demande->prenom }} {{ $demande->nom }}
- Département: {{ $demande->department->name ?? 'Non spécifié' }}
- Code d'inscription: **{{ $internCode }}**

@component('mail::button', ['url' => route('stagiaire.inscription')])
Compléter mon inscription
@endcomponent

Ce code est nécessaire pour finaliser votre inscription en tant que stagiaire.

Merci,<br>
{{ config('app.name') }}
@endcomponent