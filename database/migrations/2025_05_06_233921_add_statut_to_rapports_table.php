<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rapports', function (Blueprint $table) {
            // Ajoutez statut à la fin de la table si la colonne 'contenu' n'existe pas
            $table->string('statut')->default('en attente')
                  ->comment('en attente, validé, rejeté');
        });
    }
    
    public function down()
    {
        Schema::table('rapports', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};