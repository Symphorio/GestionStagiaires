<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedDepartmentToDemandesStageTable extends Migration
{
    public function up()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->string('assigned_department')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('demandes_stage', function (Blueprint $table) {
            $table->dropColumn('assigned_department');
        });
    }
}