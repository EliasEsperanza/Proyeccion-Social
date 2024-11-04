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
        Schema::create('proyectos_estudiantes', function (Blueprint $table) {
            $table->id("id_proyectos_estudiante");
            $table->foreignId('id_proyectos')->constrained('proyectos')->onDelete('cascade');
            $table->foreignId('id_estudiantes')->constrained('estudiantes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos_estudiantes');
    }
};
