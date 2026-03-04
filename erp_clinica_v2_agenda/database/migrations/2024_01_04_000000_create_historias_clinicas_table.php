<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historias_clinicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('medico_id')->constrained('medicos');
            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();

            $table->text('motivo_consulta');
            $table->text('examen_fisico')->nullable();
            $table->text('diagnostico');
            $table->text('tratamiento')->nullable();

            // Guardaremos la receta como un array JSON de medicamentos si queremos estructurarla,
            // o texto simple. Por ahora texto enriquecido es más flexible.
            $table->longText('receta_medica')->nullable();

            $table->text('notas_privadas')->nullable(); // Solo para ojos del médico

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historias_clinicas');
    }
};
