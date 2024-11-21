<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id('id_proyecto');
            $table->foreignId('seccion_id')->constrained('secciones', 'id_seccion')->onDelete('cascade');
            $table->text('nombre_proyecto');
            $table->text('descripcion_proyecto');
            $table->integer('horas_requeridas');
            $table->foreignId('estado')->constrained('estados', 'id_estado')->onDelete('cascade');
            $table->text('periodo');
            $table->text('lugar');
            $table->foreignId('coordinador')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->foreignId('tutor')->nullable()->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
};