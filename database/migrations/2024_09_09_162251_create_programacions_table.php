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
        Schema::create('programacions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('parametro_id');
            $table->foreign('parametro_id')->references('id')->on('parametros');

            $table->string('name')->comment('Nombre de la actividad');
            $table->date('inicio')->comment('Fecha de inicio de la actividad');
            $table->date('fin')->comment('Fecha de finalización de la actividad');
            $table->longText('observaciones')->comment('Datos importantes de la respectiva programación');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programacions');
    }
};
