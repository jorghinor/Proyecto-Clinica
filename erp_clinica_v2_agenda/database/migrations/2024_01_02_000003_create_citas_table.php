<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->foreignId('medico_id')->constrained('medicos');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('estado',['reservado','atendido','cancelado'])->default('reservado');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('citas');
    }
};
