<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attestations', function (Blueprint $table) {
            $table->id();
            $table->string('superviseur_name');
            $table->string('company_name');
            $table->text('company_address');
            $table->json('activities');
            $table->string('signature_path')->nullable();
            $table->enum('statut', ['en cours', 'complété', 'envoyé'])->default('en cours');
            $table->dateTime('date_generation');
            $table->dateTime('date_signature')->nullable();
            $table->dateTime('date_envoi')->nullable();
            $table->foreignId('rapport_id')->constrained()->onDelete('cascade');
            $table->foreignId('superviseur_id')->constrained('superviseurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attestations');
    }
};