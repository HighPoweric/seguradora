@extends('layouts.base')

@section('title', 'Participantes - SegurosPro')
@section('page-title', 'Gestión de Participantes')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <!-- Header section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Listado de Participantes</h2>
            <p class="text-gray-500 mt-1">
                Consulta y administra los participantes asociados a siniestros
            </p>
        </div>
        <a href="{{ route('participantes.create') }}"
           class="mt-4 md:mt-0 inline-flex items-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 
                  border border-transparent rounded-lg font-medium text-white shadow-sm hover:from-blue-600 
                  hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
            <i class="fas fa-user-plus mr-2"></i> Nuevo Participante
        </a>
    </div>

    <!-- Stats summary cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <div class="flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-blue-600 font-medium">Total Participantes</p>
                    <p class="text-2xl font-bold text-gray-800">{{ count($participantes) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
            <div class="flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <i class="fas fa-id-card text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-green-600 font-medium">Con Licencia</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $participantes->where('licencia_conducir', true)->count() }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
            <div class="flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <i class="fas fa-envelope text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm text-purple-600 font-medium">Con Email</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $participantes->where('email', '!=', null)->count() }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-amber-50 p-4 rounded-lg border border-amber-100">
            <div class="flex items-center">
                <div class="rounded-full bg-amber-100 p-3 mr-4">
                    <i class="fas fa-phone text-amber-600"></i>
                </div>
                <div>
                    <p class="text-sm text-amber-600 font-medium">Con Teléfono</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $participantes->where('telefono', '!=', null)->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Participantes -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RUT</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Licencia</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($participantes as $participante)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $participante->rut }}-{{ $participante->dv }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-800">{{ $participante->nombre_completo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-phone mr-2 text-gray-400"></i>
                                {{ $participante->telefono ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                {{ $participante->email ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $participante->licencia ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $participante->licencia_texto }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('participantes.show', $participante->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50 transition-colors"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('participantes.edit', $participante->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 p-2 rounded-full hover:bg-yellow-50 transition-colors"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('participantes.destroy', $participante->id) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded-full hover:bg-red-50 transition-colors"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar a {{ $participante->nombre_completo }}?')"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-users text-4xl mb-3"></i>
                                <p class="text-lg font-medium">No hay participantes registrados</p>
                                <p class="text-sm mt-1">Comienza agregando un nuevo participante</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (if applicable) -->
    @if($participantes->hasPages())
    <div class="mt-6">
        {{ $participantes->links() }}
    </div>
    @endif
</div>

<!-- Custom confirmation dialog script -->
<script>
    function confirmDelete(event, name) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Vas a eliminar a ${name}. Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit();
            }
        });
    }
</script>
@endsection