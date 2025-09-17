<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar registros existentes para que coincidan con el nuevo formato
        DB::table('participantes')->whereNotNull('licencia_conducir')->update([
            'licencia_conducir' => 'no_registra'
        ]);
        
        // Si algún registro tenía información específica, podrías hacer un mapeo más inteligente aquí
        // Por ejemplo:
        // DB::table('participantes')->where('licencia_conducir', 'LIKE', '%A1%')->update(['licencia_conducir' => 'clase_a1']);
        // DB::table('participantes')->where('licencia_conducir', 'LIKE', '%B%')->update(['licencia_conducir' => 'clase_b']);
        
        // Para registros sin licencia, establecer como "no_registra"
        DB::table('participantes')->whereNull('licencia_conducir')->update([
            'licencia_conducir' => 'no_registra'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a formato anterior (opcional)
        DB::table('participantes')->update([
            'licencia_conducir' => null
        ]);
    }
};
