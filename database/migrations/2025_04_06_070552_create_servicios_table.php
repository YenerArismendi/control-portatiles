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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $table->date('fecha_reparacion')->nullable();
            $table->integer('tipo_servicio');
            $table->string('tareas_realizadas')->nullable();
            $table->string('tecnico_responsable')->nullable();
            $table->string('repuestos_usados')->nullable();
            $table->integer('estado_final')->nullable();
            $table->integer('garantia')->nullable();
            $table->string('recomendaciones')->nullable();

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
