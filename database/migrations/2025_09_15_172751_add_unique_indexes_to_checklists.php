<?php
// database/migrations/xxxx_add_unique_indexes_to_checklists.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checklist_documentos', function (Blueprint $table) {
            $table->unique(['peritaje_id','documento_id'], 'uniq_peritaje_documento');
        });
        Schema::table('checklist_tareas', function (Blueprint $table) {
            $table->unique(['peritaje_id','tarea_id'], 'uniq_peritaje_tarea');
        });
    }
    public function down(): void
    {
        Schema::table('checklist_documentos', function (Blueprint $table) {
            $table->dropUnique('uniq_peritaje_documento');
        });
        Schema::table('checklist_tareas', function (Blueprint $table) {
            $table->dropUnique('uniq_peritaje_tarea');
        });
    }
};

