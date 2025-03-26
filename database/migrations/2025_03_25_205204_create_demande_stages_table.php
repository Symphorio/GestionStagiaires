<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demandes_stage', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('email');
            $table->string('telephone');
            $table->string('formation');
            $table->string('specialisation')->nullable();
            $table->text('lettre_motivation');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demandes_stage');
    }
};