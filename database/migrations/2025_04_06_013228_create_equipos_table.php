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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('marca', 100);
            $table->string('tipo_equipo');
            $table->string('modelo', 100)->nullable();
            $table->string('procesador', 100)->nullable();
            $table->integer('ram')->nullable();
            $table->integer('almacenamiento')->nullable();
            $table->string('sistema_operativo')->nullable();
            $table->integer('cargador')->nullable();
            $table->integer('entregado')->default(0);
            $table->string('detalles')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
