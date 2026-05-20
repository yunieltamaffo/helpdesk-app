@extends('layouts.app')
@section('title', 'Liste des tickets')
@section('content')

<!-- Filtres -->
<div class="bg-white rounded-lg shadow p-4 mb-4">
    <form method="GET" action="{{ route('tickets.index') }}" class="flex gap-3 flex-wrap">
        <select name="status" class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Tous les statuts</option>
            <option value="ouvert" {{ request('status') === 'ouvert' ? 'selected' : '' }}>Ouvert</option>
            <option value="en_cours" {{ request('status') === 'en_cours' ? 'selected' : '' }}>En cours</option>
            <option value="en_attente" {{ request('status') === 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="resolu" {{ request('status') === 'resolu' ? 'selected' : '' }}>Résolu</option>
            <option value="ferme" {{ request('status') === 'ferme' ? 'selected' : '' }}>Fermé</option>
        </select>
        <select name="priority" class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Toutes les priorités</option>
            <option value="basse" {{ request('priority') === 'basse' ? 'selected' : '' }}>Basse</option>
            <option value="moyenne" {{ request('priority') === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
            <option value="haute" {{ request('priority') === 'haute' ? 'selected' : '' }}>Haute</option>
            <option value="urgente" {{ request('priority') === 'urgente' ? 'selected' : '' }}>Urgente</option>
        </select>
        <select name="category" class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Toutes les catégories</option>
            <option value="reseau" {{ request('category') === 'reseau' ? 'selected' : '' }}>Réseau</option>
            <option value="materiel" {{ request('category') === 'materiel' ? 'selected' : '' }}>Matériel</option>
            <option value="logiciel" {{ request('category') === 'logiciel' ? 'selected' : '' }}>Logiciel</option>
            <option value="acces" {{ request('category') === 'acces' ? 'selected' : '' }}>Accès</option>
            <option value="autre" {{ request('category') === 'autre' ? 'selected' : '' }}>Autre</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
            Filtrer
        </button>
        <a href="{{ route('tickets.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
            Réinitialiser
        </a>
        @if(auth()->user()->isEmploye())
        <a href="{{ route('tickets.create') }}" class="ml-auto bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
            + Nouveau ticket
        </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">
        Tous les tickets ({{ $tickets->count() }})
    </h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3 text-gray-600">#</th>
                <th class="text-left p-3 text-gray-600">Titre</th>
                <th class="text-left p-3 text-gray-600">Catégorie</th>
                <th class="text-left p-3 text-gray-600">Priorité</th>
                <th class="text-left p-3 text-gray-600">Statut</th>
                <th class="text-left p-3 text-gray-600">Date</th>
                <th class="text-left p-3 text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3">{{ $ticket->id }}</td>
                <td class="p-3">
                    <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:underline">
                        {{ $ticket->title }}
                    </a>
                </td>
                <td class="p-3 capitalize">{{ $ticket->category }}</td>
                <td class="p-3">
                    @php
                        $colors = ['basse'=>'green','moyenne'=>'blue','haute'=>'orange','urgente'=>'red'];
                        $color = $colors[$ticket->priority] ?? 'gray';
                    @endphp
                    <span class="px-2 py-1 rounded text-xs bg-{{ $color }}-100 text-{{ $color }}-700 capitalize">
                        {{ $ticket->priority }}
                    </span>
                </td>
                <td class="p-3">
                    @php
                        $scolors = ['ouvert'=>'yellow','en_cours'=>'blue','en_attente'=>'gray','resolu'=>'green','ferme'=>'red'];
                        $sc = $scolors[$ticket->status] ?? 'gray';
                    @endphp
                    <span class="px-2 py-1 rounded text-xs bg-{{ $sc }}-100 text-{{ $sc }}-700 capitalize">
                        {{ str_replace('_', ' ', $ticket->status) }}
                    </span>
                </td>
                <td class="p-3 text-gray-400">{{ $ticket->created_at->format('d/m/Y') }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-500 hover:underline">Voir</a>
                    @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Supprimer ce ticket ?')" class="text-red-500 hover:underline">
                            Supprimer
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="p-4 text-center text-gray-400">Aucun ticket trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection