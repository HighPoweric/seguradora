@extends('layouts.base')

@section('title', 'Editar Participante - SegurosPro')
@section('page-title', 'Editar Participante')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">Editar Participante</h2>
        <p class="text-gray-600">Modifique la información del participante: {{ $participante->nombre_completo }}</p>
    </div>

    <form action="{{ route('participantes.update', $participante) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- RUT -->
            <div>
                <label for="rut" class="block text-sm font-medium text-gray-700 mb-2">RUT</label>
                <input type="text" 
                       id="rut" 
                       name="rut" 
                       value="{{ old('rut', $participante->rut) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('rut') border-red-500 @enderror"
                       placeholder="12345678"
                       required>
                @error('rut')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dígito Verificador -->
            <div>
                <label for="dv" class="block text-sm font-medium text-gray-700 mb-2">Dígito Verificador</label>
                <input type="text" 
                       id="dv" 
                       name="dv" 
                       value="{{ old('dv', $participante->dv) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('dv') border-red-500 @enderror"
                       placeholder="9"
                       maxlength="1"
                       required>
                @error('dv')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       value="{{ old('nombre', $participante->nombre) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                       placeholder="Juan Carlos"
                       required>
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apellido -->
            <div>
                <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
                <input type="text" 
                       id="apellido" 
                       name="apellido" 
                       value="{{ old('apellido', $participante->apellido) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('apellido') border-red-500 @enderror"
                       placeholder="González López"
                       required>
                @error('apellido')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                <input type="text" 
                       id="telefono" 
                       name="telefono" 
                       value="{{ old('telefono', $participante->telefono) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('telefono') border-red-500 @enderror"
                       placeholder="+56 9 1234 5678">
                @error('telefono')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $participante->email) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                       placeholder="juan.gonzalez@email.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Licencia de Conducir -->
            <div class="md:col-span-2">
                <label for="licencia_conducir" class="block text-sm font-medium text-gray-700 mb-2">Licencia de Conducir</label>
                <select id="licencia_conducir" 
                        name="licencia_conducir" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('licencia_conducir') border-red-500 @enderror">
                    @foreach(\App\Models\Participante::getLicenciasOptions() as $value => $label)
                        <option value="{{ $value }}" {{ old('licencia_conducir', $participante->licencia_conducir) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('licencia_conducir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('participantes.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i class="fas fa-save mr-2"></i>
                Actualizar Participante
            </button>
        </div>
    </form>
</div>
@endsection