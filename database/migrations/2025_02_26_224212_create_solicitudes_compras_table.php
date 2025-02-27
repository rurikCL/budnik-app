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
        Schema::create('solicitud_compra', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('IDSolicitante')->unsigned();
            $table->integer('Estado')->unsigned()->default(0);
            $table->string('Descripcion')->nullable();
            $table->string('Comentario')->nullable();
            $table->string('LugarDespacho')->nullable();
            $table->bigInteger('IDProveedor')->unsigned();

            $table->date('FechaSolicitud')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_compra');
    }
};
