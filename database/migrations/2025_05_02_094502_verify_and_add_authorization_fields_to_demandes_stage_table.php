<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            // Vérifier et ajouter chaque colonne si elle n'existe pas
            if (!Schema::hasColumn('demandes_stage', 'authorized_by')) {
                $table->foreignId('authorized_by')
                    ->nullable()
                    ->constrained('stagiaires')
                    ->onDelete('set null')
                    ->comment('Stagiaire qui a autorisé la demande');
            }
            
            if (!Schema::hasColumn('demandes_stage', 'authorized_at')) {
                $table->timestamp('authorized_at')
                    ->nullable()
                    ->comment('Date et heure de l\'autorisation');
            }
            
            if (!Schema::hasColumn('demandes_stage', 'rejected_by')) {
                $table->foreignId('rejected_by')
                    ->nullable()
                    ->constrained('stagiaires')
                    ->onDelete('set null')
                    ->comment('Stagiaire qui a rejeté la demande');
            }
            
            if (!Schema::hasColumn('demandes_stage', 'rejected_at')) {
                $table->timestamp('rejected_at')
                    ->nullable()
                    ->comment('Date et heure du rejet');
            }
            
            if (!Schema::hasColumn('demandes_stage', 'signature')) {
                $table->text('signature')
                    ->nullable()
                    ->comment('Signature électronique en format base64');
            }
        });
    }

    public function down()
    {
        // Laisser vide pour éviter de supprimer des colonnes qui pourraient être utilisées
    }
};