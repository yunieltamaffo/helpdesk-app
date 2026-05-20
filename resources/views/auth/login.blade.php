<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Helpdesk App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-700 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="text-5xl mb-3">🎫</div>
            <h1 class="text-2xl font-bold text-gray-800">Helpdesk App</h1>
            <p class="text-gray-500 text-sm mt-1">Connectez-vous à votre espace</p>
        </div>

        <!-- Erreurs -->
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 mb-4 text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Adresse email
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="exemple@email.com">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Mot de passe
                </label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="••••••••">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                Se connecter
            </button>
        </form>

        <!-- Comptes de test -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg text-xs text-gray-500">
            <p class="font-medium text-gray-600 mb-2">Comptes de test :</p>
            <p>👑 Admin : admin@helpdesk.com</p>
            <p>🔧 Technicien : tech@helpdesk.com</p>
            <p>👤 Employé : employe@helpdesk.com</p>
            <p class="mt-1">Mot de passe : <strong>password</strong></p>
        </div>

    </div>

</body>
</html>