<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    <title>@yield('title', 'SegurosPro - Gestión de Siniestros')</title>
    
    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>
<body class="text-gray-800 antialiased" x-data="{ sidebarOpen: false }">
    <!-- App container -->
    <div class="flex min-h-screen   ">
        <!-- Mobile sidebar overlay -->
        <div 
            class="sidebar-overlay" 
            :class="{ 'open': sidebarOpen }"
            @click="sidebarOpen = false"
        ></div>
        
        <!-- Sidebar -->
        <aside 
            class="sidebar fixed inset-y-0 left-0 z-50 bg-[#111827]  border-gray-200 transform -translate-x-full md:translate-x-0 md:static md:z-auto" 
            :class="{ 'translate-x-0': sidebarOpen }"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-4  border-gray-200">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-md bg-primary-700 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-white text-sm"></i>
                        </div>
                        <span class="font-semibold text-primary-100">SegurosPro</span>
                    </a>
                    <button @click="sidebarOpen = false" class="md:hidden text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ Request::is('dashboard') ? 'active text-primary-700' : 'text-primary-100 hover:text-gray-900' }}">
                        <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('caso') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ Request::is('caso*') ? 'active text-primary-700' : 'text-primary-100 hover:text-gray-900' }}">
                        <i class="fas fa-users w-5 mr-3 text-center"></i>
                        <span>Mi Caso</span>
                    </a>

                    <a href="{{ route('documents') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ Request::is('documents*') ? 'active text-primary-700' : 'text-primary-100 hover:text-gray-900' }}">
                        <i class="fas fa-file-alt w-5 mr-3 text-center"></i>
                        <span>Documentos</span>
                    </a>

                    <a href="{{ route('perito') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ Request::is('perito*') ? 'active text-primary-700' : 'text-primary-100 hover:text-gray-900' }}">
                        <i class="fas fa-user-tie w-5 mr-3 text-center"></i>
                        <span>Mi Perito</span>
                    </a>
                    
                    <a href="{{ route('interviews') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-md {{ Request::is('interviews*') ? 'active text-primary-700' : 'text-primary-100 hover:text-gray-900' }}">
                        <i class="fas fa-calendar-check w-5 mr-3 text-center"></i>
                        <span>Entrevistas</span>
                    </a>
                    
                </nav>
                
                <!-- User section -->
                <div class="px-4 py-4  border-gray-200">
                    <div class="flex items-center">
                        <div class="ml-3">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button
                                    type="submit"
                                    class=" w-full text-white px-4 py-2 rounded hover:text-red-600 mt-4 inline-flex items-center justify-center gap-2 transition-colors"
                                >
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main content -->
        <div class="main-content flex-1 flex flex-col w-full min-h-screen">
            <!-- Top navigation -->
            <header class="bg-[#111827]  border-gray-200 sticky top-0 z-30">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="md:hidden text-gray-500 mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-primary-100">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <!-- Right side items -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-1 text-primary-100 hover:text-gray-700 transition-colors">
                            <i class="far fa-bell"></i>
                            <span class="notification-dot"></span>
                        </button>

                        <!-- User menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button 
                                @click="open = !open"
                                class="flex items-center space-x-2 focus:outline-none"
                            >
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                    <span class="text-primary-700 font-medium text-sm">A</span>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-primary-100">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div 
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg  z-50 border border-gray-200"
                                style="display: none;"
                            >
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 w-full text-white px-4 py-2 mb-4 rounded hover:bg-red-600 mt-4">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-grow px-4 sm:px-6 lg:px-8 py-8 bg-[#3B4252]">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-[#3B4252]  border-gray-200 mt-auto">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="md:flex md:items-center md:justify-center md:space-x-6">
                        <p class="text-sm text-center text-primary-100">© 2025 SegurosPro. Todos los derechos reservados.</p>
                        <div class="mt-4 md:mt-0 flex space-x-6 justify-center">
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- AlpineJS for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Page-specific scripts -->
    @yield('scripts')
</body>
</html>