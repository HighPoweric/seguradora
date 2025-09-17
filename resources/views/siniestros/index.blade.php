@extends('layouts.base')

@section('title', 'Siniestros - SegurosPro')
@section('page-title', 'Gestión de Siniestros')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Listado de Siniestros</h2>
    <p class="text-gray-600 mb-6">
        Aquí puedes consultar todos los siniestros registrados, junto con sus participantes y vehículos asociados. 
        Selecciona un siniestro para ver sus detalles completos o crear un peritaje.
    </p>

    <!-- Ejemplo de tabla de siniestros -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Siniestro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Ejemplo fila -->
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">#SIN-001</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Colisión frontal</td>
                    <td class="px-6 py-4 text-sm text-gray-600">16/09/2025</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Santiago Centro</td>
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Cerrado
                        </span>
                    </td>
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
