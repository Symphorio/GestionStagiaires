<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DPAF Admin Dashboard</title>
    <meta name="description" content="Système de gestion des demandes administratives" />
    <meta name="author" content="Lovable" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <meta property="og:title" content="DPAF Admin Dashboard" />
    <meta property="og:description" content="Système de gestion des demandes administratives" />
    <meta property="og:type" content="website" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar fixe -->
        @include('partials.sidebar-dpaf')
        
        <!-- Contenu principal avec marge -->
        <main class="flex-1 ml-64 p-8 bg-slate-50 overflow-auto">
            @yield('content')
        </main>
    </div>
    
    <!-- Toast Notifications -->
    @include('partials.toast')
</body>
</html>