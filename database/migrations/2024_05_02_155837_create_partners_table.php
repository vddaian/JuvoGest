<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->integer('idSocio', true);
            $table->string('dni',9);
            $table->string('prNombre', 20);
            $table->string('sgNombre', 20)->nullable();
            $table->string('prApellido', 20);
            $table->string('sgApellido', 20)->nullable();
            $table->date('fechaNacimiento');
            $table->string('direccion', 50);
            $table->string('localidad', 20);
            $table->integer('cp');
            $table->integer('telefono')->nullable();
            $table->integer('prTelefonoResp');
            $table->integer('sgTelefonoResp')->nullable();
            $table->string('email', 50);
            $table->mediumText('alergias')->nullable();
            $table->boolean('expulsado')->default(false);
            $table->boolean('deshabilitado')->default(false);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE partners ADD foto LONGBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
