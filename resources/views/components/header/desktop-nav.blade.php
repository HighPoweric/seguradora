<nav class="hidden md:flex items-center space-x-8">
    <a href="#features" class="text-gray-700 hover:text-blue-800 transition-colors">Características</a>
    <a href="#how-it-works" class="text-gray-700 hover:text-blue-800 transition-colors">Cómo funciona</a>
    <a href="#testimonials" class="text-gray-700 hover:text-blue-800 transition-colors">Testimonios</a>
    @guest
    <button
    @click="loginModalOpen = true"
    class="bg-blue-900 text-white px-5 py-2 rounded-lg hover:bg-blue-800 transition-colors">
    Iniciar Sesión
    </button>
    @endguest

    {{-- Si SÍ está logeado --}}
    @auth
    <a
    href="{{ route('dashboard') }}"
    class="bg-blue-900 text-white px-5 py-2 rounded-lg hover:bg-blue-800 transition-colors">
    Mi Panel
    </a>
    @endauth
</nav>
