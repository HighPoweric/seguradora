<form x-data="loginForm()" @submit.prevent="submitLogin()" class="p-6">
    @csrf
    
    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Correo Electrónico
        </label>
        <input 
            type="email" 
            id="email" 
            name="email"
            x-model="form.email"
            required 
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="admin@seguros.com">
        <div x-show="errors.email" x-text="errors.email" class="text-red-500 text-sm mt-1"></div>
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            Contraseña
        </label>
        <div class="relative">
            <input 
                :type="showPassword ? 'text' : 'password'"
                id="password" 
                name="password"
                x-model="form.password"
                required 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10"
                placeholder="••••••••">
            <button 
                type="button" 
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-400"></i>
            </button>
        </div>
        <div x-show="errors.password" x-text="errors.password" class="text-red-500 text-sm mt-1"></div>
    </div>

    <!-- Remember Me -->
    <div class="mb-6">
        <label class="flex items-center">
            <input 
                type="checkbox" 
                name="remember"
                x-model="form.remember"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
        </label>
    </div>

    <!-- Submit Button -->
    <button 
        type="submit"
        :disabled="isLoading"
        :class="isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
        <span x-show="!isLoading">Iniciar Sesión</span>
        <span x-show="isLoading" class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Iniciando...
        </span>
    </button>

    <!-- Error General -->
    <div x-show="errors.general" x-text="errors.general" class="text-red-500 text-sm mt-4 text-center"></div>
</form>

<script>
function loginForm() {
    return {
        form: {
            email: '',
            password: '',
            remember: false
        },
        errors: {},
        isLoading: false,
        showPassword: false,

        async submitLogin() {
            this.isLoading = true;
            this.errors = {};

            try {
                // Usamos FormData para enviar datos como un formulario normal
                const formData = new FormData();
                formData.append('email', this.form.email);
                formData.append('password', this.form.password);
                formData.append('remember', this.form.remember ? '1' : '0');
                
                // Obtener el token CSRF del input hidden en el formulario
                const csrfInput = document.querySelector('input[name="_token"]');
                if (csrfInput) {
                    formData.append('_token', csrfInput.value);
                } else {
                    throw new Error('Token CSRF no encontrado');
                }

                const response = await fetch('/login', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin' // Importante para mantener las cookies de sesión
                });

                // Verificar si la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Respuesta del servidor no es JSON válido');
                }

                const data = await response.json();

                if (response.ok && data.success) {
                    // Login exitoso - redirigir al dashboard
                    window.location.href = data.redirect;
                } else {
                    // Manejar errores de validación
                    this.errors = data.errors || {};
                    if (data.message) {
                        this.errors.general = data.message;
                    }
                }
            } catch (error) {
                console.error('Error de login:', error);
                this.errors.general = 'Error de conexión. Inténtelo de nuevo.';
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>