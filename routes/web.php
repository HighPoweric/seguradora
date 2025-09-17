<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ParticipanteController;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas del dashboard y módulos principales
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');

    // Casos (asignados al perito)
    Route::get('/casos', function () {
        return view('casos.index');
    })->name('casos.index');

    // Siniestros (hecho objetivo del accidente)
    Route::get('/siniestros', function () {
        return view('siniestros.index');
    })->name('siniestros.index');

    // Participantes (personas involucradas)
    Route::resource('participantes', ParticipanteController::class);

    // Vehículos
    Route::get('/vehiculos', function () {
        return view('vehiculos.index');
    })->name('vehiculos.index');

    // Entrevistas / Agenda
    Route::get('/entrevistas', function () {
        return view('entrevistas.index');
    })->name('entrevistas.index');

    // Documentos de los casos
    Route::get('/documentos', function () {
        return view('documentos.index');
    })->name('documentos.index');

    // Reportes (opcional, para dashboards más analíticos)
    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');

    // Configuración (parámetros de la app / perfil del perito)
    Route::get('/configuracion', function () {
        return view('configuracion.index');
    })->name('configuracion.index');
});

// Si necesitas rutas con parámetros o recursos:
// Route::resource('participants', ParticipantController::class);
// Route::resource('experts', ExpertController::class);
// Route::resource('incidents', IncidentController::class);