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
        Schema::create('checklist_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos')->onDelete('cascade');
            $table->foreignId('peritaje_id')->constrained('peritajes')->onDelete('cascade');
            $table->boolean('requerido')->default(true);
            $table->boolean('cargado')->default(false)->description('Indica si el documento ha sido cargado al sistema');
            $table->string('ruta')->nullable()->description('Ruta donde se almacena el documento cargado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklist_documentos', function (Blueprint $table) {
            $table->dropForeign(['documento_id']);
            $table->dropForeign(['peritaje_id']);            
        });
        Schema::dropIfExists('checklist_documentos');
    
    }
};
