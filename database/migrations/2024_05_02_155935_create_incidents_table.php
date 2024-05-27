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
        Schema::create('incidents', function (Blueprint $table) {
            $table->integer('idIncidencia', true);
            $table->string('idUsuario');
            $table->integer('idSocio');
            $table->date('fechaInc');
            $table->date('fechaFinExp');
            $table->text('informacion')->nullable();
            $table->enum('tipo', ['LEVE', 'GRAVE', 'MUY GRAVE']);
            $table->boolean('deshabilitado')->default(false);
            $table->foreign('idSocio')->references('idSocio')->on('partners');
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
