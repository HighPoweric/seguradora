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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('patente')->unique()->description('Patente del vehículo');
            $table->enum('tipo', ['auto', 'camioneta', 'moto'])->description('Tipo de vehículo');
            $table->string('marca')->description('Marca del vehículo');
            $table->string('modelo')->description('Modelo del vehículo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
