<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id('id_documento');
            $table->foreignId('id_proyecto')->constrained('proyectos', 'id_proyecto');
            $table->text('tipo_documento');
            $table->text('ruta_archivo');
            $table->date('fecha_subida');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
