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
        Schema::create('records_partners', function (Blueprint $table) {
            $table->integer('idRegistro');
            $table->string('dni');
            $table->foreign('dni')->references('dni')->on('partners');
            $table->foreign('idRegistro')->references('idRegistro')->on('records');
            $table->primary(['dni','idRegistro']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_socios');
    }
};
