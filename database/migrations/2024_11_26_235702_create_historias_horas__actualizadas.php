<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar si la tabla ya existe, y crearla solo si no existe
        if (!Schema::hasTable('historias_horas_actualizadas')) {
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
                $table->integer('horas_aceptadas');  // Campo de horas aceptadas
                $table->timestamp('fecha_aceptacion')->nullable();  // Fecha de aceptación
                $table->timestamps();
            });
        }

        // Crear el trigger para insertar en la tabla historias_horas_actualizadas
        DB::unprepared('
            CREATE TRIGGER after_estado_update
            AFTER UPDATE ON solicitudes
            FOR EACH ROW
            WHEN NEW.estado IN (7, 10)
            BEGIN
                INSERT INTO historias_horas_actualizadas (
                    id_estudiante, 
                    id_solicitud, 
                    id_proyecto, 
                    horas_aceptadas, 
                    fecha_aceptacion, 
                    created_at, 
                    updated_at
                )
                VALUES (
                    NEW.id_estudiante, 
                    NEW.id_solicitud, 
                    NEW.id_proyecto, 
                    NEW.valor, 
                    datetime(\'now\'), 
                    datetime(\'now\'), 
                    datetime(\'now\')
                );
            END;
        ');
    }

    public function down(): void
    {
        // Eliminar el trigger si existe
        DB::unprepared('DROP TRIGGER IF EXISTS after_estado_update');

        // Eliminar la tabla si existe
        Schema::dropIfExists('historias_horas_actualizadas');
    }
};
