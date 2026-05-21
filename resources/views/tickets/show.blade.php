@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')
@section('title', 'Détail du ticket')
@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Détails du ticket -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold text-gray-800">{{ $ticket->title }}</h2>
                <span class="px-3 py-1 rounded text-sm
                    {{ $ticket->status === 'ouvert' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $ticket->status === 'en_cours' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $ticket->status === 'resolu' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $ticket->status === 'ferme' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $ticket->status === 'en_attente' ? 'bg-gray-100 text-gray-700' : '' }}">
                    {{ str_replace('_', ' ', $ticket->status) }}
                </span>
            </div>

            <p class="text-gray-600 mb-4">{{ $ticket->description }}</p>

            <div class="grid grid-cols-3 gap-4 text-sm text-gray-500">
                <div><span class="font-medium">Catégorie :</span> {{ $ticket->category }}</div>
                <div><span class="font-medium">Priorité :</span> {{ $ticket->priority }}</div>
                <div><span class="font-medium">Créé le :</span> {{ $ticket->created_at->format('d/m/Y') }}</div>
            </div>
        </div>

        @if($ticket->attachment)
            <div class="mt-3">
                <a href="{{ Storage::url($ticket->attachment) }}" target="_blank"
                    class="inline-flex items-center gap-2 text-blue-600 hover:underline text-sm">
                    📎 Voir la pièce jointe
                </a>
            </div>
        @endif

        <!-- Changer le statut (technicien/admin) -->
        @if(auth()->user()->isAdmin() || auth()->user()->isTechnicien())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-3">Changer le statut</h3>
                <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="flex gap-3">
                    @csrf @method('PUT')
                    <select name="status" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="ouvert" {{ $ticket->status === 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                        <option value="en_cours" {{ $ticket->status === 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="en_attente" {{ $ticket->status === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="resolu" {{ $ticket->status === 'resolu' ? 'selected' : '' }}>Résolu</option>
                        <option value="ferme" {{ $ticket->status === 'ferme' ? 'selected' : '' }}>Fermé</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Mettre à jour
                    </button>
                </form>
            </div>
        @endif

        <!-- Commentaires -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Commentaires ({{ $comments->count() }})</h3>

            @forelse($comments as $comment)
                <div class="border-b py-3">
                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                        <span class="font-medium text-gray-700">{{ $comment->user->name }}</span>
                        <span>{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <p class="text-gray-600">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Aucun commentaire pour le moment.</p>
            @endforelse

            <!-- Ajouter un commentaire -->
            <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}" class="mt-4">
                @csrf
                <textarea name="content" rows="3" placeholder="Ajouter un commentaire..."
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    Envoyer
                </button>
            </form>
        </div>

        <a href="{{ route('tickets.index') }}" class="text-blue-500 hover:underline text-sm">← Retour à la liste</a>
    </div>

@endsection