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
        Schema::create('papeles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('fecha')->comment('Fecha del movimiento');
            $table->string('documento')->comment('tipo de documento');
            $table->string('numero')->comment('Numero del documento');
            $table->string('destinatario')->comment('A nombre de quien se creo el documento');
            $table->string('documento_dest')->comment('Numero del documento del destinatario');
            $table->double('valor')->comment('Valor neto del movimiento');
            $table->double('iva')->nullable()->comment('Impuesto aplicable');
            $table->double('total')->comment('valor total del movimiento');
            $table->integer('calculos')->default(0)->comment('control de calculos generados, impuestos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papeles');
    }
};
