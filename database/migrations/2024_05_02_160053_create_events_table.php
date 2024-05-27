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
        Schema::create('events', function (Blueprint $table) {
            $table->integer('idEvento', true);
            $table->integer('idSala');
            $table->string('titulo', 30);
            $table->string('entidadOrg', 30);
            $table->integer('numeroAsistentes');
            $table->date('fechaEvento');
            $table->time('horaEvento');
            $table->text('informacion')->nullable();
            $table->boolean('deshabilitado')->default(false);
            $table->foreign('idSala')->references('idSala')->on('rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
