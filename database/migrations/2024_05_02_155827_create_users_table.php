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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nombreEntidad', 30);
            $table->string('username', 20);
            $table->string('password', 60);
            $table->string('direccion', 50);
            $table->string('localidad', 20);
            $table->integer('cp');
            $table->integer('telefono');
            $table->string('email', 50);
            $table->text('foto')->nullable();
            $table->enum('rol', ['Admin', 'User'])->default('User');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
