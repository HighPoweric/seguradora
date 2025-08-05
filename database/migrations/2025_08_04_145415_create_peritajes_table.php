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
            Schema::create('peritajes', function (Blueprint $table) {
                $table->id();
                $table->string('solicitante')->description('Nombre del solicitante del peritaje');
                $table->foreignId('siniestro_id')->constrained('siniestros');
                $table->foreignId('perito_id')->constrained('peritos');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('peritajes');
        }
    };
