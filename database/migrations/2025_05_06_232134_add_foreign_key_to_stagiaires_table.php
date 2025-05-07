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
            // Mettre à jour les valeurs NULL avec un superviseur existant
            $superviseur = DB::table('superviseurs')->first();
            $defaultSuperviseurId = $superviseur ? $superviseur->id : null;
    
            if ($defaultSuperviseurId) {
                DB::table('stagiaires')
                    ->whereNull('superviseur_id')
                    ->update(['superviseur_id' => $defaultSuperviseurId]);
            }
    
            // Ajouter la contrainte
            $table->foreign('superviseur_id')
                  ->references('id')
                  ->on('superviseurs')
                  ->onDelete('cascade')
                  ->change();
        });
    }
    
    public function down()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->dropForeign(['superviseur_id']);
        });
    }
};
