<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documento_peritaje', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peritaje_id')->constrained()->cascadeOnDelete();
            $table->foreignId('documento_id')->constrained()->cascadeOnDelete();

            // Campos adicionales para el requerimiento
            $table->boolean('requerido')->default(true);
            $table->enum('estado', ['pendiente', 'entregado', 'rechazado'])->default('pendiente');
            $table->text('observacion')->nullable();

            $table->timestamps();

            $table->unique(['peritaje_id','documento_id']); // evita duplicados
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documento_peritaje');
    }
};
