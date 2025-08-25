<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentos = [
            [
                'nombre' => 'Cédula de Identidad',
                'descripcion' => 'Documento de identificación del participante',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Licencia de Conducir',
                'descripcion' => 'Licencia de conducir vigente del conductor',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Permiso de Circulación',
                'descripcion' => 'Permiso de circulación del vehículo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Póliza de Seguro',
                'descripcion' => 'Póliza de seguro del vehículo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Parte Policial',
                'descripcion' => 'Informe policial del siniestro',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Fotografías del Vehículo',
                'descripcion' => 'Fotografías de los daños del vehículo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Certificado Médico',
                'descripcion' => 'Certificado médico en caso de lesiones',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Declaración Jurada',
                'descripcion' => 'Declaración jurada del siniestro',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('documentos')->insert($documentos);
    }
}

