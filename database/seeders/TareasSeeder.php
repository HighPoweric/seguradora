<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TareasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tareas = [
            [
                'tarea' => 'Inspección del vehículo',
                'descripcion' => 'Realizar inspección completa del vehículo siniestrado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Entrevista con el conductor',
                'descripcion' => 'Entrevistar al conductor del vehículo para obtener su versión de los hechos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Entrevista con testigos',
                'descripcion' => 'Entrevistar a testigos presenciales del siniestro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Revisión de documentación',
                'descripcion' => 'Revisar y validar toda la documentación relacionada al siniestro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Fotografías del lugar',
                'descripcion' => 'Tomar fotografías del lugar del siniestro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Medición de daños',
                'descripcion' => 'Medir y evaluar los daños del vehículo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Verificación de póliza',
                'descripcion' => 'Verificar vigencia y cobertura de la póliza de seguro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Elaboración de informe',
                'descripcion' => 'Elaborar informe pericial completo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Cotización de reparaciones',
                'descripcion' => 'Obtener cotizaciones para reparación del vehículo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tarea' => 'Análisis de responsabilidad',
                'descripcion' => 'Analizar y determinar responsabilidades en el siniestro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tareas')->insert($tareas);
    }
}

