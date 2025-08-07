<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['auto', 'camioneta', 'moto'];
        $marcasModelos = [
            'Toyota' => ['Corolla', 'Hilux', 'Yaris'],
            'Hyundai' => ['Accent', 'Tucson', 'Elantra'],
            'Chevrolet' => ['Spark', 'Tracker', 'Sail'],
            'Honda' => ['Civic', 'CR-V', 'Fit'],
        ];

        for ($i = 1; $i <= 20; $i++) {
            $marca = array_rand($marcasModelos);
            $modelo = collect($marcasModelos[$marca])->random();
            $tipo = collect($tipos)->random();

            Vehiculo::create([
                'patente' => strtoupper('ABC' . str_pad($i, 3, '0', STR_PAD_LEFT)),
                'tipo' => $tipo,
                'marca' => $marca,
                'modelo' => $modelo,
            ]);
        }
    }
}
