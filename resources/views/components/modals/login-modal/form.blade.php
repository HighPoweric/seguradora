<div class="px-8">
    <form class="space-y-6" onsubmit="handleLoginSubmit(event)">
        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent" placeholder="tu@email.com" required>
        </div>
        
        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent" placeholder="••••••••" required>
        </div>
        
        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-900 focus:ring-blue-900 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Recordarme</label>
            </div>
            <a href="#" class="text-sm text-blue-900 hover:text-blue-700">¿Olvidaste tu contraseña?</a>
        </div>
        
        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full bg-blue-900 text-white py-3 px-4 rounded-lg hover:bg-blue-800 transition-colors font-medium">
                Iniciar Sesión
            </button>
        </div>
    </form>
</div>
