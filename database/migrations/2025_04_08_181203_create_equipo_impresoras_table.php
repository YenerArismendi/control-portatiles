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
        Schema::create('equipo_impresoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('marca');
            $table->string('modelo')->nullable();
            $table->string('tipo');
            $table->string('serie')->nullable();
            $table->string('fallo_reportado')->nullable();
            $table->integer('estado');
            $table->time('fecha_entrega')->nullable();
            $table->integer('cargador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_impresoras');
    }
};
