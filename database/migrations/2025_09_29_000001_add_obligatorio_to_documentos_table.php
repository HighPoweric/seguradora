<?php

// database/migrations/2025_09_29_000001_add_obligatorio_to_documentos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            // Ajusta el ->after() al nombre real de alguna columna (por estética)
            $table->boolean('obligatorio')->default(false)->index()->after('nombre');
        });
    }

    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn('obligatorio');
        });
    }
};
