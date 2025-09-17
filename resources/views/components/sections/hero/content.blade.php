<div class="text-center lg:text-left fade-in">
    <h1 class="text-4xl md:text-5xl font-bold text-blue-900 mb-6 leading-tight">
        Gestión profesional de siniestros vehiculares
    </h1>
    <p class="text-lg text-gray-600 mb-8 max-w-xl mx-auto lg:mx-0">
        Simplifica el proceso de gestión de siniestros con nuestra plataforma integral. Carga documentación, sube grabaciones, revisa estados y genera informes automatizados para tu aseguradora.
    </p>
    <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
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
        href="{{ route('dashboard.index') }}"
        class="bg-blue-900 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-800 transition-colors shadow-lg">
        Mi Panel
        </a>
        @endauth
        <a href="#features" class="bg-white border border-gray-200 text-gray-800 px-8 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors text-center">
            Ver características
        </a>
    </div>
</div>
