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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique()->comment('Nombre de la empresa');
            $table->longText('direccion');
            $table->string('telefono');
            $table->string('persona_contacto');
            $table->string('email')->comment('Email de la empresa y/o de la persona de contacto');
            $table->longText('productos')->comment('Registrará los cambios en el cliente');
            $table->boolean('status')->default(true)->comment('false Inactivo, true Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
