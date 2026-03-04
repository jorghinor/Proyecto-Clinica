<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consentimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->string('titulo'); // Ej: Consentimiento de Extracción
            $table->longText('contenido_legal'); // El texto que el paciente leyó
            $table->string('firma_digital_path')->nullable(); // Ruta de la imagen de la firma
            $table->enum('estado', ['borrador', 'firmado'])->default('borrador');
            $table->timestamp('fecha_firma')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consentimientos');
    }
};
