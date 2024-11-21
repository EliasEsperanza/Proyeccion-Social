<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asignaciones', function (Blueprint $table) {
    $table->id('id_asignacion');
    $table->unsignedBigInteger('id_proyecto');
    $table->unsignedBigInteger('id_estudiante');
    $table->unsignedBigInteger('id_tutor');
    $table->date('fecha_asignacion');
    $table->timestamps();
    
    $table->foreign('id_proyecto')->references('id_proyecto')->on('proyectos');
    $table->foreign('id_estudiante')->references('id_estudiante')->on('estudiantes');
    $table->foreign('id_tutor')->references('id_usuario')->on('users');
});
    }

    public function down()
    {
        Schema::dropIfExists('asignaciones');
    }
};