@extends('layouts.base')

@section('title', 'Dashboard - SegurosPro')
@section('page-title', 'Gestión de Siniestros – Persona Asegurada')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">¡Bienvenido al Dashboard!</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-500 text-white p-6 rounded-lg">
            <h3 class="text-xl font-semibold mb-2">Siniestros</h3>
            <p class="text-blue-100">Gestionar siniestros activos</p>
        </div>
        
        <div class="bg-green-500 text-white p-6 rounded-lg">
            <h3 class="text-xl font-semibold mb-2">Peritos</h3>
            <p class="text-green-100">Administrar peritos</p>
        </div>
        
        <div class="bg-purple-500 text-white p-6 rounded-lg">
            <h3 class="text-xl font-semibold mb-2">Reportes</h3>
            <p class="text-purple-100">Ver estadísticas</p>
        </div>
    </div>
</div>
@endsection