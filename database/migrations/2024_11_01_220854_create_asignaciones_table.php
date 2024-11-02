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
        Schema::create('asignaciones', function (Blueprint $table) { 
        $table->id('id_asignacion'); 
        $table->foreignId('id_proyecto')->constrained('proyectos', 'id_proyecto'); 
        $table->foreignId('id_estudiante')->constrained('estudiantes', 'id_estudiante');
        $table->foreignId('id_tutor')->constrained('usuarios', 'id_usuario'); 
        $table->date('fecha_asignacion'); 
        $table->timestamps(); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};
