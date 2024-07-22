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
        Schema::create('parametros', function (Blueprint $table) {

            $table->id();

            $table->string('name')->comment('Nombre del parámetro');
            $table->integer('tipo')->comment('1 carpeta (organizar documentos), 2 DIAN (resoluciones, declaraciones, etc), 3 impuesto');
            $table->double('porcentaje')->default(0)->comment('Porcentaje de calculo cuando son impuestos');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};
