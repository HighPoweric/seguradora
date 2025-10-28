<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class Participante extends Model
{
    // Constantes para tipos de licencia de conducir en Chile (clasificación oficial)
    const LICENCIAS_CONDUCIR = [
        'no_registra' => 'No registra',
        
        // PROFESIONALES (Clase A)
        'clase_a1' => 'Clase A1 - Taxis',
        'clase_a2' => 'Clase A2 - Taxis, ambulancias, transporte 10-17 pasajeros',
        'clase_a3' => 'Clase A3 - Taxis, transporte escolar, ambulancias, transporte público',
        'clase_a4' => 'Clase A4 - Transporte de carga superior a 3.500 kg',
        'clase_a5' => 'Clase A5 - Vehículos de carga articulados superior a 3.500 kg',
        
        // NO PROFESIONALES
        'clase_b' => 'Clase B - Vehículos particulares (automóviles, camionetas)',
        'clase_c' => 'Clase C - Motocicletas y motonetas',
        'clase_cr' => 'Clase CR - Motocicletas y motonetas (restringida)',
        
        // ESPECIALES
        'clase_d' => 'Clase D - Maquinaria automotriz (tractores, palas mecánicas)',
        'clase_e' => 'Clase E - Vehículos de tracción animal',
        'clase_f' => 'Clase F - Vehículos policiales, bomberos y fuerzas armadas',
    ];

    /**
     * Devuelve el esquema del formulario para Filament basado en los campos de la migración.
     */
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('rut')
                ->label('RUT')
                ->required()
                ->unique()
                ->maxLength(12),
            TextInput::make('dv')
                ->label('Dígito verificador')
                ->required()
                ->maxLength(2),
            TextInput::make('nombre')
                ->label('Nombre')
                ->required()
                ->maxLength(50),
            TextInput::make('apellido')
                ->label('Apellido')
                ->required()
                ->maxLength(50),
            TextInput::make('telefono')
                ->label('Teléfono')
                ->maxLength(20),
            TextInput::make('email')
                ->label('Correo electrónico')
                ->email()
                ->maxLength(100),
            TextInput::make('licencia_conducir')
                ->label('Licencia de conducir')
                ->maxLength(30),
        ];
    }
    // Habilitar asignación masiva para estos campos
    protected $fillable = [
        'rut',
        'dv',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'licencia_conducir',
    ];

    // Si deseas ocultar campos en arrays o respuestas JSON (opcional)
    // protected $hidden = [];

    // Si deseas agregar atributos virtuales como "nombre_completo"
    protected $appends = ['nombre_completo'];

    //agregamos relacion n:n con siniestros a traves de la tabla pivote participante_siniestro
    public function siniestros()
    {
        return $this->belongsToMany(Siniestro::class, 'participante_siniestro')
            ->withTimestamps();
    }
    
    //agregamos la relacion con Entrevistas
    public function entrevistas(): HasMany
    {
        return $this->hasMany(Entrevista::class);
    }

    //agregamos relacion con la pivot participante_siniestro
    public function participanteSiniestros(): HasMany
    {
        return $this->hasMany(ParticipanteSiniestro::class);
    }

    /**
     * Atributo virtual: nombre completo
     * Permite usar `$participante->nombre_completo` en las vistas
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    //nombre completo mas Rut-dv
    public function getNombreCompletoRutAttribute() : string
    {
        return "{$this->nombre} {$this->apellido} ({$this->rut}-{$this->dv})";
    }

    /**
     * Obtener el texto legible de la licencia de conducir
     */
    public function getLicenciaTextoAttribute(): string
    {
        return self::LICENCIAS_CONDUCIR[$this->licencia_conducir] ?? 'No especificada';
    }

    /**
     * Obtener todas las opciones de licencias de conducir
     */
    public static function getLicenciasOptions(): array
    {
        return self::LICENCIAS_CONDUCIR;
    }
}
