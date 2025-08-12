<div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95" class="md:hidden absolute top-full left-0 right-0 bg-white shadow-lg py-4 px-4 rounded-b-lg">
    <div class="flex flex-col space-y-4">
        <a href="#features" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-blue-800">Características</a>
        <a href="#how-it-works" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-blue-800">Cómo funciona</a>
        <a href="#testimonials" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-blue-800">Testimonios</a>
        <button @click="loginModalOpen = true; mobileMenuOpen = false" class="bg-blue-900 text-white px-5 py-2 rounded-lg hover:bg-blue-800 w-full">
            Iniciar Sesión
        </button>
    </div>
</div>
