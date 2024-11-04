<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proyectos_documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_documento');
            $table->unsignedBigInteger('id_proyecto');
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('id_documento')->references('id_documento')->on('documentos')->onDelete('cascade');
            $table->foreign('id_proyecto')->references('id_proyecto')->on('proyectos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos_documentos');
    }
};
