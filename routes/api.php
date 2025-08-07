<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiniestroController;

//creando endpoint para POST https://seu-app.com/api/siniestros
Route::post('/siniestros', [SiniestroController::class, 'store'])
    ->name('siniestros.store')
    ->middleware('auth:sanctum')
    ->description('Registrar un nuevo siniestro');