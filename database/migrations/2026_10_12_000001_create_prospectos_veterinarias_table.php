<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prospectos_veterinarias', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social')->index();
            $table->string('correo_comercial')->unique();
            $table->string('telefono')->nullable()->index();
            $table->string('departamento')->default('Cundinamarca')->index();
            $table->string('municipio')->default('Bogotá D.C.')->index();
            $table->string('direccion')->nullable();
            $table->string('tipo')->nullable(); // Clínica, Hospital, Consultorio, Pet Shop
            $table->string('estado')->default('pendiente')->index(); // pendiente, enviado, error, respondido, desuscrito
            $table->unsignedInteger('intentos_envio')->default(0);
            $table->timestamp('ultimo_envio_at')->nullable()->index();
            $table->text('error_mensaje')->nullable();
            $table->string('fuente')->default('Google Maps / Directorio');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prospectos_veterinarias');
    }
};
