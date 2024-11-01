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
        Schema::create('calculos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('papele_id');
            $table->foreign('papele_id')->references('id')->on('papeles');

            $table->unsignedBigInteger('parametro_id');
            $table->foreign('parametro_id')->references('id')->on('parametros');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->double('valor')->comment('Valor calculado');
            $table->date('fecha')->comment('fecha del papel cargado');
            $table->date('fecha_calculo')->nullable()->comment('fecha en que se carga el calculo');
            $table->integer('status')->default(1)->comment('1 proceso, 2 calculado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculos');
    }
};
