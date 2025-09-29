<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siniestros', function (Blueprint $table) {
            $table->string('aseguradora', 120)
                ->nullable()
                ->after('status');

            $table->index('aseguradora');
        });
    }

    public function down(): void
    {
        Schema::table('siniestros', function (Blueprint $table) {
            // Primero elimina el índice y luego la columna
            $table->dropIndex(['aseguradora']); // o: $table->dropIndex('siniestros_aseguradora_index');
            $table->dropColumn('aseguradora');
        });
    }
};
