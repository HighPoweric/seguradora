<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('peritajes', function (Blueprint $table) {
            $table->timestamp('iniciado_at')->nullable()->after('fecha_siniestro');
        });
    }

    public function down(): void
    {
        Schema::table('peritajes', function (Blueprint $table) {
            $table->dropColumn('iniciado_at');
        });
    }
};
