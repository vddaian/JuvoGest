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
            $table->string('dni');
            $table->string('idUsuario');
            $table->boolean('expulsado')->default(false);
            $table->boolean('deshabilitado')->default(false);
            $table->date('fechaAlta');
            $table->foreign('dni')->references('dni')->on('partners');
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->primary(['dni','idUsuario']);
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
