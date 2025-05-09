<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Rapport;

return new class extends Migration
{
    public function up()
    {
        // 1. Modifier la structure si nécessaire (valeurs par défaut)
        Schema::table('rapports', function (Blueprint $table) {
            $table->string('statut')->default('en attente')->change();
            $table->timestamp('submitted_at')->nullable()->change();
        });

        // 2. Compléter les données manquantes
        Rapport::whereNull('submitted_at')->each(function ($rapport) {
            $rapport->update([
                'submitted_at' => $rapport->created_at ?? now(),
                'statut' => 'en attente'
            ]);
        });

        // Pour les champs file_path et original_name vides (si applicable)
        Rapport::whereNull('file_path')->orWhereNull('original_name')->each(function ($rapport) {
            $rapport->update([
                'file_path' => $rapport->file_path ?? 'archives/rapports/defaut.pdf',
                'original_name' => $rapport->original_name ?? 'rapport_defaut.pdf'
            ]);
        });
    }

    public function down()
    {
        // Optionnel : définir comment annuler les changements si nécessaire
    }
};