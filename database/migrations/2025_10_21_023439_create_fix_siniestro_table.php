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
   

        //en la tabla de entrevistas eliminamo peritaje_id, participante_id y agregamos participante_siniestro
        Schema::table('entrevistas', function (Blueprint $table) {
            $table->dropForeign(['peritaje_id']);
            $table->dropForeign(['participante_id']);
            $table->dropColumn('peritaje_id');
            $table->dropColumn('participante_id');
            $table->foreignId('participante_siniestro_id')->constrained('participante_siniestro')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siniestros', function (Blueprint $table) {
            $table->foreignId('asegurado_id')->nullable()->constrained('participantes')->description('Asegurado del siniestro');
            $table->foreignId('denunciante_id')->nullable()->constrained('participantes')->description('Denunciante del siniestro');
            $table->foreignId('conductor_id')->nullable()->constrained('participantes')->description('Conductor del siniestro');
            $table->foreignId('contratante_id')->nullable()->constrained('participantes')->description('contratante del plan de seguros');
            $table->string('relacion_asegurado_conductor')->nullable()->description('Relación entre el asegurado y el conductor');
        });
        Schema::table('entrevistas', function (Blueprint $table) {
            $table->foreignId('peritaje_id')->constrained('peritajes');
            $table->foreignId('participante_id')->constrained('participantes');
            $table->dropForeign(['participante_siniestro_id']);
            $table->dropColumn('participante_siniestro_id');
        });
    }

};
