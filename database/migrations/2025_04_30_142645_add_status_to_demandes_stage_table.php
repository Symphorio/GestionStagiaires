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
        Schema::table('demandes_stage', function (Blueprint $table) {
            // Utilisez 'status' ou 'statut' selon votre besoin
            if (!Schema::hasColumn('demandes_stage', 'status')) {
                $table->string('status')->default('en_attente_sg');
            }
        });
    }
    
    public function down()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
