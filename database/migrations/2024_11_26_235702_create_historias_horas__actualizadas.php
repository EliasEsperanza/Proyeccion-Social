<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historias_horas_actualizadas', function (Blueprint $table) {
            $table->id('id_horas_actualizadas');
            $table->foreignId('id_estudiante')
                ->constrained('estudiantes', 'id_estudiante')
                ->onDelete('cascade');
            $table->foreignId('id_solicitud')
                ->constrained('solicitudes', 'solicitud_id')
                ->onDelete('cascade');
            $table->foreignId('id_proyecto')  // Relación con la tabla proyectos
                ->constrained('proyectos', 'id_proyecto')
                ->onDelete('cascade');
            $table->integer('horas_aceptadas');  // Añadido el campo de horas aceptadas
            $table->timestamp('fecha_aceptacion')->nullable();  // Fecha de aceptación
            $table->timestamps();
        });

        // Crear el trigger para insertar en la tabla historias_horas_actualizadas
        DB::unprepared('
            CREATE TRIGGER after_estado_update
            AFTER UPDATE ON solicitudes
            FOR EACH ROW
            BEGIN
                IF NEW.estado IN (7, 10) THEN
                    INSERT INTO historias_horas_actualizadas (id_estudiante, id_solicitud, id_proyecto, horas_aceptadas, fecha_aceptacion, created_at, updated_at)
                    VALUES (NEW.id_estudiante, NEW.solicitud_id, NEW.id_proyecto, NEW.valor, NOW(), NOW(), NOW());
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_estado_update');
        Schema::dropIfExists('historias_horas_actualizadas');
    }
};
