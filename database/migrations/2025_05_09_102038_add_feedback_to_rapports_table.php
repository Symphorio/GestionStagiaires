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
        Schema::table('rapports', function (Blueprint $table) {
            $table->text('feedback')->nullable()->after('statut');
        });
    }
    
    public function down()
    {
        Schema::table('rapports', function (Blueprint $table) {
            $table->dropColumn('feedback');
        });
    }
};
