<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes');
            // Opcional: vincular a una cita específica
            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();

            $table->string('numero_factura')->unique()->nullable(); // Para folios fiscales o internos
            $table->date('fecha_emision');
            $table->enum('estado', ['pendiente', 'pagada', 'anulada'])->default('pendiente');
            $table->enum('metodo_pago', ['efectivo', 'tarjeta_credito', 'tarjeta_debito', 'transferencia', 'seguro'])->nullable();

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('impuestos', 10, 2)->default(0); // IVA u otros
            $table->decimal('total', 10, 2)->default(0);

            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

        Schema::create('factura_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('facturas')->cascadeOnDelete();

            $table->string('descripcion'); // Ej: Consulta General
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2); // cantidad * precio

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factura_items');
        Schema::dropIfExists('facturas');
    }
};
