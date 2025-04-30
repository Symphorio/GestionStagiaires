@extends('layouts.sg')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Toutes les demandes de stage</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Demandes en attente de traitement</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom</th>
                            <th>Formation</th>
                            <th>Période</th>
                            <th>Date demande</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $demande)
                            <tr>
                                <td>{{ $demande->prenom }} {{ $demande->nom }}</td>
                                <td>{{ $demande->formation ?? 'N/A' }}</td>
                                <td>
                                    {{ $demande->date_debut->format('d/m/Y') }}<br>
                                    {{ $demande->date_fin->format('d/m/Y') }}
                                </td>
                                <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $demande->status === 'en_attente_sg' ? 'warning' : 'success' }}">
                                        {{ $demande->status === 'en_attente_sg' ? 'En attente' : 'Transférée' }}
                                    </span>
                                </td>
                                <td>
                                    @if($demande->status === 'en_attente_sg')
                                        <form action="{{ route('sg.requests.forward', $demande->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-primary" title="Transférer à la DPAF">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Déjà traitée</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune demande en attente</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection