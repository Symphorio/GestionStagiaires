<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id')->constrained('stagiaires')->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('couleur')->default('#3b82f6');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evenements');
    }
};