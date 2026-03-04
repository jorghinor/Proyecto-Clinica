<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('medico_id')->constrained('medicos');
            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();
            $table->text('medicamentos'); // Lista de medicamentos y dosis
            $table->text('indicaciones')->nullable();
            $table->string('archivo_path')->nullable(); // PDF de la receta si se genera/sube
            $table->date('fecha_emision')->default(now());
            $table->timestamps();
        });

        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();
            $table->string('tipo_examen'); // Ej: Análisis de Sangre, Rayos X
            $table->text('descripcion')->nullable();
            $table->string('archivo_path'); // El archivo del resultado es obligatorio
            $table->date('fecha_resultado')->default(now());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultados');
        Schema::dropIfExists('recetas');
    }
};
