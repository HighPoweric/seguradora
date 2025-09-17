@extends('layouts.base')

@section('title', 'Ver Participante - SegurosPro')
@section('page-title', 'Detalles del Participante')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">{{ $participante->nombre_completo }}</h2>
        <p class="text-gray-600">RUT: {{ $participante->rut }}-{{ $participante->dv }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Información Personal -->
        <div class="space-y-4">
            <h3 class="text-md font-medium text-gray-900 border-b border-gray-200 pb-2">Información Personal</h3>
            
            <div>
                <label class="block text-sm font-medium text-gray-500">Nombre Completo</label>
                <p class="text-gray-900">{{ $participante->nombre_completo }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500">RUT</label>
                <p class="text-gray-900">{{ $participante->rut }}-{{ $participante->dv }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500">Licencia de Conducir</label>
                <p class="text-gray-900">{{ $participante->licencia_texto }}</p>
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="space-y-4">
            <h3 class="text-md font-medium text-gray-900 border-b border-gray-200 pb-2">Información de Contacto</h3>
            
            <div>
                <label class="block text-sm font-medium text-gray-500">Teléfono</label>
                <p class="text-gray-900">{{ $participante->telefono ?? 'No registrado' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500">Email</label>
                <p class="text-gray-900">{{ $participante->email ?? 'No registrado' }}</p>
            </div>
        </div>
    </div>

    <!-- Información del Sistema -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-md font-medium text-gray-900 mb-4">Información del Sistema</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-500">Fecha de Registro</label>
                <p class="text-gray-900">{{ $participante->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Última Actualización</label>
                <p class="text-gray-900">{{ $participante->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
        <a href="{{ route('participantes.index') }}" 
           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver al Listado
        </a>
        <a href="{{ route('participantes.edit', $participante) }}" 
           class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            <i class="fas fa-edit mr-2"></i>
            Editar Participante
        </a>
    </div>
</div>
@endsection