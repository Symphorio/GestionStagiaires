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
            $table->string('intern_code')->nullable()->after('department_id');
        });
    }
    
    public function down()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->dropColumn('intern_code');
        });
    }
};
