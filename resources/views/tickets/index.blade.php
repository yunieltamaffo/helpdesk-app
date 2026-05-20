@extends('layouts.app')
@section('title', 'Liste des tickets')
@section('content')

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Tous les tickets</h2>
        @if(auth()->user()->isEmploye())
        <a href="{{ route('tickets.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Nouveau ticket
        </a>
        @endif
    </div>
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
                    <a href="{{ route('tickets.show', $ticket) }}"
                       class="text-blue-600 hover:underline">
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
                    <a href="{{ route('tickets.show', $ticket) }}"
                       class="text-blue-500 hover:underline">Voir</a>
                    @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Supprimer ce ticket ?')"
                                class="text-red-500 hover:underline">
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