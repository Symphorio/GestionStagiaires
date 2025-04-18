<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('intern_id')->unique();
            $table->string('password');
            $table->boolean('is_validated')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('role_id')->default(1);   // Ajoutez sans contrainte pour le moment
        });

        // Ajoutez cette instruction pour créer la contrainte après
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    public function down(): void
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists('stagiaires');
    }
};