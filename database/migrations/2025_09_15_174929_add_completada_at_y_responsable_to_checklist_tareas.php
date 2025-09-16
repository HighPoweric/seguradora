<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_completada_at_y_responsable_to_checklist_tareas.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checklist_tareas', function (Blueprint $table) {
            $table->timestamp('completada_at')->nullable()->after('estado');
            $table->foreignId('responsable_id')->nullable()->after('completada_at')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('checklist_tareas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('responsable_id');
            $table->dropColumn('completada_at');
        });
    }
};
