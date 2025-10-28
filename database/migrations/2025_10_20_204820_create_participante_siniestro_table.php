<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participante_siniestro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siniestro_id')->constrained('siniestros');
            $table->foreignId('participante_id')->constrained('participantes');
            $table->boolean('asegurado')->default(false);
            $table->boolean('conductor')->default(false);
            $table->boolean('contratante')->default(false);
            $table->boolean('denunciante')->default(false);
            $table->string('otro_rol')->nullable()->description('ejemplo: amigo testigo, carabinero,');

            $table->timestamps();
            $table->unique(['siniestro_id', 'participante_id']);
            $table->unique(['siniestro_id', 'asegurado'], 'unique_asegurado_per_siniestro')->where('asegurado', true);
            $table->unique(['siniestro_id', 'conductor'], 'unique_conductor_per_siniestro')->where('conductor', true);
            $table->unique(['siniestro_id', 'contratante'], 'unique_contratante_per_siniestro')->where('contratante', true);
            $table->unique(['siniestro_id', 'denunciante'], 'unique_denunciante_per_siniestro')->where('denunciante', true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //eliminamos las constrains y las relaciones antes de eliminar la tabla
        Schema::table('participante_siniestro', function (Blueprint $table) {
            $table->dropUnique(['siniestro_id', 'participante_id']);
            $table->dropUnique('unique_asegurado_per_siniestro');
            $table->dropUnique('unique_conductor_per_siniestro');
            $table->dropUnique('unique_contratante_per_siniestro');
            $table->dropUnique('unique_denunciante_per_siniestro');
            $table->dropForeign(['siniestro_id']);
            $table->dropForeign(['participante_id']);
        });
        Schema::dropIfExists('participante_siniestro');
    }
};
