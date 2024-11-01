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
        Schema::create('proyectos', function (Blueprint $table) {

            $table->id('id_proyecto');
            $table->text('nombre_proyecto');
            $table->text('estado');
            $table->text('periodo');
            $table->text('lugar');
            $table->unsignedBigInteger('coordinador');

            // Se añade la clave foránea solo si la tabla 'usuarios' existe

            if (Schema::hasTable('usuarios')) {
                $table->foreign('coordinador')->references('id_usuario')->on('usuarios');
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
