<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id('id_estudiante');
            $table->foreignId('id_usuario')
                ->constrained('users', 'id_usuario')
                ->onDelete('cascade');
            $table->foreignId('id_seccion')
                ->constrained('secciones', 'id_seccion')
                ->onDelete('cascade');
            $table->decimal('porcentaje_completado', 5, 2);
            $table->integer('horas_sociales_completadas');
            $table->timestamps();
        });

        // Trigger para insertar el rol de estudiante en la tabla model_has_roles de spatie
        DB::unprepared('
            CREATE TRIGGER after_estudiante_insert
            AFTER INSERT ON estudiantes
            FOR EACH ROW
            BEGIN
                INSERT INTO model_has_roles (role_id, model_type, model_id)
                SELECT id, "App\\Models\\User", NEW.id_usuario
                FROM roles
                WHERE name = "estudiante";
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_estudiante_insert');
        Schema::dropIfExists('estudiantes');
    }
};
