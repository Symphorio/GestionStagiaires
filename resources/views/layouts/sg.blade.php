<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SG Admin Dashboard</title>
    <meta name="description" content="Système de gestion des demandes administratives" />
    <meta name="author" content="Lovable" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <meta property="og:title" content="SG Admin Dashboard" />
    <meta property="og:description" content="Système de gestion des demandes administratives" />
    <meta property="og:type" content="website" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
  </head>

  <body class="bg-slate-50">
    <div class="min-h-screen flex">
        @include('partials.sidebar-admin')
        
        <main class="flex-1 p-8 bg-slate-50 overflow-auto">
            @yield('content')
        </main>
    </div>
    
    @stack('scripts')
  </body>
</html>
