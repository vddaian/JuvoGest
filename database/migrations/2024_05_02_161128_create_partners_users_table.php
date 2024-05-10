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
        Schema::create('partners_users', function (Blueprint $table) {
            $table->integer('idSocio');
            $table->string('idUsuario');
            $table->foreign('idSocio')->references('idSocio')->on('partners');
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->primary(['idSocio','idUsuario']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios_usuarios');
    }
};
