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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id('solicitud_id');
            $table->foreignId('id_estudiante')
                ->constrained('estudiantes', 'id_estudiante') 
                ->onDelete('cascade');
            $table->foreignId('id_proyecto')
                ->constrained('proyectos', 'id_proyecto') 
                ->onDelete('cascade');
            $table->double('valor');
            $table->string('documento');
            $table->foreignId('estado')
                ->constrained('estados', 'id_estado')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
