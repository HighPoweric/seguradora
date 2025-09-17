@extends('layouts.base')

@section('title', 'Crear Participante - SegurosPro')
@section('page-title', 'Crear Nuevo Participante')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <!-- Header section -->
    <div class="mb-8">
        <div class="flex items-center mb-3">
            <div class="rounded-full bg-blue-100 p-3 mr-4">
                <i class="fas fa-user-plus text-blue-600 text-xl"></i>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800">Crear Nuevo Participante</h2>
        </div>
        <p class="text-gray-500 ml-14">
            Complete la información del participante involucrado en el siniestro.
        </p>
    </div>

    <form action="{{ route('participantes.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- RUT -->
            <div class="space-y-2">
                <label for="rut" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-id-card text-gray-400 mr-2 text-sm"></i>
                    RUT
                </label>
                <input type="text" 
                       id="rut" 
                       name="rut" 
                       value="{{ old('rut') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('rut') border-red-500 ring-1 ring-red-500 @enderror"
                       placeholder="12345678"
                       required>
                @error('rut')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Dígito Verificador -->
            <div class="space-y-2">
                <label for="dv" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-key text-gray-400 mr-2 text-sm"></i>
                    Dígito Verificador
                </label>
                <input type="text" 
                       id="dv" 
                       name="dv" 
                       value="{{ old('dv') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('dv') border-red-500 ring-1 ring-red-500 @enderror"
                       placeholder="9"
                       maxlength="1"
                       required>
                @error('dv')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nombre -->
            <div class="space-y-2">
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-signature text-gray-400 mr-2 text-sm"></i>
                    Nombre
                </label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       value="{{ old('nombre') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('nombre') border-red-500 ring-1 ring-red-500 @enderror"
                       placeholder="Juan Carlos"
                       required>
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Apellido -->
            <div class="space-y-2">
                <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-signature text-gray-400 mr-2 text-sm"></i>
                    Apellido
                </label>
                <input type="text" 
                       id="apellido" 
                       name="apellido" 
                       value="{{ old('apellido') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('apellido') border-red-500 ring-1 ring-red-500 @enderror"
                       placeholder="González López"
                       required>
                @error('apellido')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div class="space-y-2">
                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                    Teléfono
                </label>
                <input type="text" 
                       id="telefono" 
                       name="telefono" 
                       value="{{ old('telefono') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('telefono') border-red-500 ring-1 ring-red-500 @enderror"
                       placeholder="+56 9 1234 5678">
                @error('telefono')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                    Email
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 ring-1 ring-red-500 @enderror"
                       placeholder="juan.gonzalez@email.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Licencia de Conducir -->
            <div class="md:col-span-2 space-y-2">
                <label for="licencia_conducir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-id-card text-gray-400 mr-2 text-sm"></i>
                    Licencia de Conducir
                </label>
                <select id="licencia_conducir" 
                        name="licencia_conducir" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('licencia_conducir') border-red-500 ring-1 ring-red-500 @enderror">
                    @foreach(\App\Models\Participante::getLicenciasOptions() as $value => $label)
                        <option value="{{ $value }}" {{ old('licencia_conducir') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('licencia_conducir')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Botones -->
        <div class="flex flex-col-reverse sm:flex-row justify-end space-y-4 sm:space-y-0 space-x-0 sm:space-x-3 pt-8 border-t border-gray-200">
            <a href="{{ route('participantes.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Cancelar
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-sm hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all mb-4 sm:mb-0">
                <i class="fas fa-save mr-2"></i>
                Guardar Participante
            </button>
        </div>
    </form>
</div>

<!-- Script para mejorar la experiencia del formulario -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar máscara para el RUT
        const rutInput = document.getElementById('rut');
        if (rutInput) {
            rutInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });
        }

        // Agregar máscara para el teléfono
        const telefonoInput = document.getElementById('telefono');
        if (telefonoInput) {
            telefonoInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^\d+()\s-]/g, '');
                e.target.value = value;
            });
        }

        // Auto-mayúsculas para nombre y apellido
        const nombreInput = document.getElementById('nombre');
        const apellidoInput = document.getElementById('apellido');
        
        if (nombreInput) {
            nombreInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
            });
        }
        
        if (apellidoInput) {
            apellidoInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
            });
        }
    });
</script>
@endsection