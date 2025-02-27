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
        Schema::create('detalle_solicitud', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('IDSolicitud')->unsigned();
            $table->bigInteger('IDSolicitante')->unsigned();
            $table->bigInteger('IDRechazo')->unsigned();
            $table->integer('Estado')->unsigned()->default(0);
            $table->string('Descripcion')->nullable();
            $table->string('DescUnidad')->nullable();
            $table->integer('Cantidad')->nullable();
            $table->integer('CostoUnitario')->nullable();
            $table->integer('CostoTotal')->nullable();
            $table->integer('CuentaContable')->nullable();
            $table->integer('UnidadNegocio')->nullable();
            $table->integer('CentroCosto')->nullable();
            $table->integer('SubCentro')->nullable();
            $table->integer('LugarFisico')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_solicitud');
    }
};
