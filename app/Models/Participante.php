<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Relación con peritajes (si corresponde)
     * Este método puedes eliminarlo si no usas esta relación
     */
    public function peritajes(): HasMany
    {
        return $this->hasMany(Peritaje::class, 'participante_id');
    }

    /**
     * Atributo virtual: nombre completo
     * Permite usar `$participante->nombre_completo` en las vistas
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
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
