@extends('layouts.app')
@section('title', 'Gestion des utilisateurs')
@section('content')

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Utilisateurs ({{ $users->count() }})</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3 text-gray-600">#</th>
                <th class="text-left p-3 text-gray-600">Nom</th>
                <th class="text-left p-3 text-gray-600">Email</th>
                <th class="text-left p-3 text-gray-600">Rôle</th>
                <th class="text-left p-3 text-gray-600">Inscrit le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3 font-medium">{{ $user->name }}</td>
                <td class="p-3 text-gray-500">{{ $user->email }}</td>
                <td class="p-3">
                    @php
                        $rc = ['admin'=>'red','technicien'=>'blue','employe'=>'green'];
                        $rc2 = $rc[$user->role] ?? 'gray';
                    @endphp
                    <span class="px-2 py-1 rounded text-xs bg-{{ $rc2 }}-100 text-{{ $rc2 }}-700 capitalize">
                        {{ $user->role }}
                    </span>
                </td>
                <td class="p-3 text-gray-400">{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection