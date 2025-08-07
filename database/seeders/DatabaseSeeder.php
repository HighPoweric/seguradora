<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehiculo;
use App\Models\Participante;
use App\Models\Perito;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Vehículos
        Vehiculo::factory()->createMany([
            ['patente' => 'ABC123', 'tipo' => 'auto', 'marca' => 'Toyota', 'modelo' => 'Yaris'],
            ['patente' => 'XYZ789', 'tipo' => 'camioneta', 'marca' => 'Nissan', 'modelo' => 'Navara'],
            ['patente' => 'JHK456', 'tipo' => 'moto', 'marca' => 'Yamaha', 'modelo' => 'FZ'],
        ]);

        // Participantes
        Participante::factory()->createMany([
            [
                'rut' => '12345678', 'dv' => '9',
                'nombre' => 'Juan', 'apellido' => 'Pérez',
                'telefono' => '912345678', 'email' => 'juan@example.com',
                'licencia_conducir' => 'LIC123456'
            ],
            [
                'rut' => '87654321', 'dv' => 'K',
                'nombre' => 'Ana', 'apellido' => 'Gómez',
                'telefono' => '976543210', 'email' => 'ana@example.com',
                'licencia_conducir' => 'LIC654321'
            ],
            [
                'rut' => '11223344', 'dv' => '8',
                'nombre' => 'Luis', 'apellido' => 'Torres',
                'telefono' => '987654321', 'email' => 'luis@example.com',
                'licencia_conducir' => 'LIC789123'
            ],
        ]);

        // Peritos
        Perito::factory()->createMany([
            ['nombre' => 'Carlos', 'apellido' => 'Muñoz', 'telefono' => '911111111', 'email' => 'carlos@peritos.cl'],
            ['nombre' => 'María', 'apellido' => 'López', 'telefono' => '922222222', 'email' => 'maria@peritos.cl'],
        ]);
    }
}
