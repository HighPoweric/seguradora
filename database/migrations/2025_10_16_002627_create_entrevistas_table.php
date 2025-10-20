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
        //migration para crear tabla entrevistas
        Schema::create('entrevistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peritaje_id')->constrained('peritajes');
            $table->foreignId('participante_id')->constrained('participantes');
            $table->foreignId('perito_id')->constrained('peritos')->nullable()->description('Perito que realiza la entrevista');
            $table->dateTime('fecha_entrevista')->nullable()->description('Fecha y hora agendada para la entrevista');
            $table->string('archivo_audio')->nullable()->description('Ruta del archivo de audio de la entrevista');
            $table->text('transcripcion')->nullable()->description('Transcripción de la entrevista');
            //$table->foreignId('estado_id')->constrained('entrevistas_estados')->description('Estado actual de la entrevista');
            $table->enum('estado', ['no iniciada', 'aguardando agenda', 'agendada', 'completada'])->default('no iniciada')->description('Estado actual de la entrevista');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrevistas');
    }
};
