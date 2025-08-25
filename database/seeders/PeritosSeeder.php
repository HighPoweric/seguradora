<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeritosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peritos = [
            [
                'nombre' => 'Carlos',
                'apellido' => 'González',
                'telefono' => '+56912345678',
                'email' => 'carlos.gonzalez@peritajes.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María',
                'apellido' => 'Silva',
                'telefono' => '+56987654321',
                'email' => 'maria.silva@peritajes.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Roberto',
                'apellido' => 'Mendoza',
                'telefono' => '+56911223344',
                'email' => 'roberto.mendoza@peritajes.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Torres',
                'telefono' => '+56955667788',
                'email' => 'ana.torres@peritajes.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'Ramírez',
                'telefono' => '+56933445566',
                'email' => 'luis.ramirez@peritajes.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('peritos')->insert($peritos);
    }
}

