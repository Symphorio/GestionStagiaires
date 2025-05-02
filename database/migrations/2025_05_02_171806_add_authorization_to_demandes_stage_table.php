<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->boolean('authorization')->default(false)->after('department');
        });
    }

    public function down()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->dropColumn('authorization');
        });
    }
};