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
        Schema::create('soportes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parametro_id');
            $table->foreign('parametro_id')->references('id')->on('parametros');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('cargado_id');
            $table->foreign('cargado_id')->references('id')->on('users');

            $table->string('ruta')->comment('donde esta guardado el archivo');
            $table->string('parame')->comment('Etiqueta que se le dio al archivo');
            $table->string('clien')->comment('Cliente al que pertenece el soporte');
            $table->string('name')->comment('nombre del documento');
            $table->longText('observaciones');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soportes');
    }
};
