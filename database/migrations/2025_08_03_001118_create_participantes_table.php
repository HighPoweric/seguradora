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
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->unique()->description('RUT del participante');
            $table->string('dv')->description('Dígito verificador del RUT');
            $table->string('nombre')->description('Nombre del participante');
            $table->string('apellido')->description('Apellido del participante');
            $table->string('telefono')->nullable()->description('Teléfono del participante');
            $table->string('email')->nullable()->description('Correo electrónico del participante');
            $table->string('licencia_conducir')->nullable()->description('Número de licencia de conducir del participante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
