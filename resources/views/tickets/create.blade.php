@extends('layouts.app')
@section('title', 'Créer un ticket')
@section('content')

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-6">Nouveau ticket</h2>

        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Ex: Imprimante en panne">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Décrivez votre problème en détail...">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select name="category"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="reseau">Réseau</option>
                        <option value="materiel">Matériel</option>
                        <option value="logiciel">Logiciel</option>
                        <option value="acces">Accès</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                    <select name="priority"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="basse">Basse</option>
                        <option value="moyenne" selected>Moyenne</option>
                        <option value="haute">Haute</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Pièce jointe <span class="text-gray-400">(optionnel — PDF, image, Word)</span>
                </label>
                <input type="file" name="attachment"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                @error('attachment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3">
                <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data"></form>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Créer le ticket
                </button>
                <a href="{{ route('tickets.index') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>

@endsection