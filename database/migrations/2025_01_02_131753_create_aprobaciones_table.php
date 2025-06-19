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
        Schema::create('aprobaciones_solicitud', function (Blueprint $table) {
            $table->id();
//            $table->bigInteger('IDSolicitud')->unsigned();
            $table->string('IDExterno', 50)->nullable();
            $table->bigInteger('IDAprobador')->unsigned();
            $table->integer('Nivel');
            $table->string('Estado')->default(0); // 0:Pendiente, 1:Aprobado, 3:Rechazado
            $table->dateTime('FechaAprobacion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aprobaciones_solicitud');
    }
};
