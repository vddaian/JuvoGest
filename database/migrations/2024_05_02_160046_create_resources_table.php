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
        Schema::create('resources', function (Blueprint $table) {
            $table->integer('idRecurso', true);
            $table->integer('idSala');
            $table->string('nombre', 30);
            $table->enum('tipo', ['JUEGOS', 'OFICINA', 'OTROS']);
            $table->foreign('idSala')->references('idSala')->on('rooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};
