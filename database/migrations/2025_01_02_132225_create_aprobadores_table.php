<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aprobadores_solicitud', function (Blueprint $table) {
            $table->id();
            $table->integer('Nivel');
            $table->bigInteger('IDAprobador')->unsigned();
            $table->bigInteger('IDReemplazo')->unsigned();
            $table->bigInteger('idSolicitudTipo')->unsigned()->nullable();
            $table->integer('Activo')->default(1); // 0: Inactivo, 1: Activo, 2: Reemplazo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aprobadores');
    }
};
