<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File as FacadesFile;

return new class extends Migration {
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
            $table->enum('rol', ['Admin', 'User'])->default('User');
            $table->boolean('deshabilitado')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE users ADD foto LONGBLOB");

        User::create([
            'id' => Str::uuid(),
            'nombreEntidad' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'direccion' => 'X',
            'localidad' => 'X',
            'rol' => 'Admin',
            'cp' => 99999,
            'telefono' => 999999999,
            'email' => 'admin@juvogest.com',
            'foto' => base64_encode(FacadesFile::get(public_path('media/img/user-default.png')))
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
