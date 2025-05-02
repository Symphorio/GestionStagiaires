<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
                  
            // Supprimez l'ancienne colonne si elle existe
            if (Schema::hasColumn('demandes_stage', 'department')) {
                $table->dropColumn('department');
            }
        });
    }

    public function down()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
            $table->string('department')->nullable();
        });
    }
};