@extends('layouts.base')

@section('title', 'Casos - SegurosPro')
@section('page-title', 'Mis Casos Asignados')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Listado de Casos</h2>
    <p class="text-gray-600 mb-6">
        Aquí puedes ver todos los casos de siniestros que te han sido asignados para gestionar.
        Selecciona un caso para revisar sus participantes, vehículos, documentos y el estado del peritaje.
    </p>

    <!-- Ejemplo de tabla de casos -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Caso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siniestro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Asignación</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Ejemplo fila -->
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">#CAS-001</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Colisión múltiple</td>
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            En Proceso
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">15/09/2025</td>
                    <td class="px-6 py-4 text-right">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Ver detalles</a>
                    </td>
                </tr>
                <!-- Fin ejemplo fila -->
            </tbody>
        </table>
    </div>
</div>
@endsection
