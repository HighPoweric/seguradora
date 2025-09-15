<!-- CTA Section -->
<section class="py-16 bg-blue-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Simplifica la gestión de siniestros hoy mismo</h2>
        <p class="text-blue-100 max-w-2xl mx-auto mb-8">
            Únete a cientos de profesionales que ya optimizan sus procesos con SegurosPro
        </p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            @guest
            <button @click="loginModalOpen = true" class="bg-white text-blue-900 px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                Comenzar ahora
            </button>
            @endguest
            @auth
            <a
            href="{{ route('dashboard') }}"
            class="bg-white text-blue-900 px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
            Mi Panel
            </a>
            @endauth
            <a href="#features" class="bg-transparent border border-white text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-800 transition-colors text-center">
                Ver características
            </a>
        </div>
    </div>
</section>
