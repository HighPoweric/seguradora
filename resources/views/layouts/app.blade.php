<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SegurosPro - Gestión de Siniestros')</title>
    
    <!-- CDN Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
    <!-- Additional styles -->
    @stack('styles')
</head>
<body x-data="homePageData()" class="relative">
    <!-- Header Component -->
    @include('components.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer Component -->
    @include('components.footer')
    
    <!-- Modal Components -->
    @include('components.modals.login-modal')
    
    <!-- Custom JavaScript -->
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    
    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>
