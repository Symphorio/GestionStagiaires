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
            // D'abord ajouter la colonne sans contrainte
            $table->unsignedBigInteger('superviseur_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->dropForeign(['superviseur_id']);
            $table->dropColumn('superviseur_id');
        });
    }
};
