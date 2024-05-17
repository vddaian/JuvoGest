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
            $table->string('dni');
            $table->date('fechaInc');
            $table->date('fechaFinExp');
            $table->text('informacion');
            $table->boolean('deshabilitado')->default(false);
            $table->foreign('dni')->references('dni')->on('partners');
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
