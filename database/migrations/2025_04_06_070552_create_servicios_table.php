<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cotizacion_id');
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('cascade');

            $table->morphs('equipo'); // Crea `equipo_id` y `equipo_type`

            $table->string('tecnico_responsable')->nullable();
            $table->string('fallo_reportado')->nullable();
            $table->string('diagnostico')->nullable();
            $table->integer('estado')->default(0);
            $table->string('descripcion_servicio')->nullable();
            $table->integer('garantia')->nullable();
            $table->string('recomendaciones')->nullable();
            $table->decimal('total_servicio', 10, 2);
            $table->date('fecha_reparacion')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
