<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checklist_tareas', function (Blueprint $table) {
            if (! Schema::hasColumn('checklist_tareas', 'completada_at')) {
                $table->timestamp('completada_at')->nullable()->after('estado');
            }
            if (! Schema::hasColumn('checklist_tareas', 'responsable_id')) {
                $table->foreignId('responsable_id')
                    ->nullable()
                    ->after('completada_at')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('checklist_tareas', function (Blueprint $table) {
            if (Schema::hasColumn('checklist_tareas', 'responsable_id')) {
                $table->dropConstrainedForeignId('responsable_id');
            }
            if (Schema::hasColumn('checklist_tareas', 'completada_at')) {
                $table->dropColumn('completada_at');
            }
        });
    }
};
