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
        Schema::table('attestations', function (Blueprint $table) {
            // Pour ENUM
            $table->enum('statut', ['en cours', 'complété', 'signé', 'envoyé'])->default('en cours')->change();
            
            // Ou pour string
            // $table->string('statut', 20)->default('en cours')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attestations', function (Blueprint $table) {
            //
        });
    }
};
