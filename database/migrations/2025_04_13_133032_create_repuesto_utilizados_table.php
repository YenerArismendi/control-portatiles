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
        Schema::create('repuesto_utilizados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_id')->constrained('servicios')->cascadeOnDelete();
            $table->unsignedBigInteger('repuesto_id')->constrained('servicios')->cascadeOnDelete();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repuesto_utilizados');
    }
};
