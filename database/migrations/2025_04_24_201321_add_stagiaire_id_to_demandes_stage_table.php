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
        $table->unsignedBigInteger('stagiaire_id')->nullable()->after('id');
        $table->foreign('stagiaire_id')->references('id')->on('stagiaires');
    });
}

public function down()
{
    Schema::table('demandes_stage', function (Blueprint $table) {
        $table->dropForeign(['stagiaire_id']);
        $table->dropColumn('stagiaire_id');
    });
}
};
