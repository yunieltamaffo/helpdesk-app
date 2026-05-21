<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <!-- Mobile navbar -->
    <div class="lg:hidden bg-blue-800 text-white px-4 py-3 flex justify-between items-center">
        <span class="font-bold text-lg">🎫 Helpdesk</span>
        <button onclick="document.getElementById('sidebar').classList.toggle('hidden')"
                class="text-white focus:outline-none">
            ☰
        </button>
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="hidden lg:flex w-64 bg-blue-800 text-white flex-col fixed lg:relative z-50 h-full">
            <div class="p-6 text-xl font-bold border-b border-blue-700 hidden lg:block">
                🎫 Helpdesk App
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2 p-3 rounded hover:bg-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('tickets.index') }}"
                   class="flex items-center gap-2 p-3 rounded hover:bg-blue-700 {{ request()->routeIs('tickets.*') ? 'bg-blue-700' : '' }}">
                    🎫 Tickets
                </a>
                @if(auth()->user()->isEmploye())
                <a href="{{ route('tickets.create') }}"
                   class="flex items-center gap-2 p-3 rounded hover:bg-blue-700">
                    ➕ Nouveau ticket
                </a>
                @endif
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-2 p-3 rounded hover:bg-blue-700">
                    👥 Utilisateurs
                </a>
                @endif
            </nav>
            <div class="p-4 border-t border-blue-700">
                <p class="text-sm text-blue-200">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-300 capitalize">{{ auth()->user()->role }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="text-sm text-red-300 hover:text-red-100">
                        🚪 Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenu principal -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h1 class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</h1>
                <span class="text-sm text-gray-500 hidden sm:block">{{ now()->format('d/m/Y') }}</span>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>