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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique()->comment('Nombre de la empresa');
            $table->string('nit')->unique()->comment('numero de identificación del cliente');
            $table->integer('DV')->comment('digito de verificación de los clientes');
            $table->string('representante_legal')->comment('Gerente de la empresa');
            $table->string('cedula_rl')->comment('documento del representante');
            $table->longText('direccion');
            $table->string('telefono');
            $table->string('persona_contacto');
            $table->string('email')->comment('Email de la empresa y/o de la persona de contacto');
            $table->string('software_contable');
            $table->string('usuario');
            $table->string('llave');
            $table->string('matricula');
            $table->longText('bitacora')->comment('Registrará los cambios en el cliente');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
