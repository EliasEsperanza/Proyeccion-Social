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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id('id_estudiante');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_seccion');
            $table->foreign('id_seccion')
                ->references('id_seccion')
                ->on('secciones')
                ->onDelete('cascade');
            $table->decimal('porcentaje_completado');
            $table->integer('horas_sociales_completadas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
