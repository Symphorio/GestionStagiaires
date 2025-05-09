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
        \App\Models\Rapport::whereNotNull('file_path')->each(function ($rapport) {
            // Corriger les chemins si nécessaire (ex: enlever 'public/' s'il est présent)
            if (str_starts_with($rapport->file_path, 'public/')) {
                $rapport->file_path = str_replace('public/', '', $rapport->file_path);
                $rapport->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
