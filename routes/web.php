<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas del dashboard y módulos principales
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/caso', function () {
    return view('caso');
})->middleware('auth')->name('caso');

Route::get('/documents', function () {
    return view('documents');
})->middleware('auth')->name('documents');

Route::get('/perito', function () {
    return view('perito');
})->middleware('auth')->name('perito');

Route::get('/interviews', function () {
    return view('interviews');
})->middleware('auth')->name('interviews');

// Si necesitas rutas con parámetros o recursos:
// Route::resource('participants', ParticipantController::class);
// Route::resource('experts', ExpertController::class);
// Route::resource('incidents', IncidentController::class);