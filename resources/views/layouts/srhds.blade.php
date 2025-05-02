<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRHDS - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar fixe -->
        @include('partials.sidebar-srhds')
        
        <!-- Contenu principal avec marge pour la sidebar -->
        <main class="ml-64 flex-1 p-6 min-h-screen">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>