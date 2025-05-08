<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->string('telephone')->nullable();
            $table->string('niveau_etude')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('statut')->default('actif');
        });
    }
    
    public function down()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->dropColumn([
                'telephone',
                'niveau_etude',
                'date_debut',
                'date_fin',
                'statut'
            ]);
        });
    }
};
