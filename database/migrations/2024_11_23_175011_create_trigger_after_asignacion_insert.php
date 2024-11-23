<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER after_asignacion_insert
            AFTER INSERT ON asignaciones
            FOR EACH ROW
            BEGIN
                INSERT INTO proyectos_estudiantes (id_proyecto, id_estudiante, created_at, updated_at)
                VALUES (NEW.id_proyecto, NEW.id_estudiante, NOW(), NOW());
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_asignacion_insert;");
    }
};
