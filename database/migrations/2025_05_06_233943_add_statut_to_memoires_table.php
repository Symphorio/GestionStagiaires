<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->string('statut')->default('en attente')
                  ->comment('en attente, validé, rejeté');
        });
    }

    public function down()
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};