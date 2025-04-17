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
        if (!Schema::hasTable('item_cotizacions')) {
            Schema::create('item_cotizacions', function (Blueprint $table) {
                $table->id();
                // Relaciones
                $table->foreignId('cotizacion_id')->constrained()->onDelete('cascade');
                $table->foreignId('repuesto_id')->constrained()->onDelete('cascade');

                // Campos de detalle
                $table->integer('cantidad');
                $table->decimal('precio_unitario', 10, 2);
                $table->decimal('subtotal', 10, 2);
                $table->string('descripcion');
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_cotizacions');
    }
};
