<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //tabla que asocia las tareas al peritaje
    public function up(): void
    {
        Schema::create('checklist_tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->onDelete('cascade');
            $table->foreignId('peritaje_id')->constrained('peritajes')->onDelete('cascade');
            $table->enum('estado', ['no_iniciada','pendiente', 'en_proceso', 'completada'])->default('no_iniciada');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklist_tareas', function (Blueprint $table) {
            $table->dropForeign(['tarea_id']);
            $table->dropForeign(['peritaje_id']);
        });
        Schema::dropIfExists('checklist_tareas');
    }
};
