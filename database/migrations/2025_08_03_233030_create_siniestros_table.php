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
        Schema::create('siniestros', function (Blueprint $table) {
            $table->id();
            $table->string('id_interno')->unique()->description('Identificador por parte de la aseguradora');
            $table->foreignId('vehiculo_id')->constrained('vehiculo');
            $table->foreignId('asegurado_id')->constrained('participantes')->description('Asegurado del siniestro');
            $table->foreignId('denunciante_id')->nullable()->constrained('participantes')->description('Denunciante del siniestro');
            $table->foreignId('conductor_id')->constrained('participantes')->description('Conductor del siniestro');
            $table->foreignId('contratante_id')->nullable()->constrained('participantes')->description('contratante del plan de seguros');
            $table->string('relacion_asegurado_conductor')->description('Relación entre el asegurado y el conductor');
            $table->string('direccion_aproximada')->description('Dirección aproximada del siniestro');
            $table->double('latitud')->description('Latitud del siniestro');
            $table->double('longitud')->description('Longitud del siniestro');
            $table->enum('status', ['pendiente', 'investigacion', 'completado']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siniestros');
    }
};
