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
    Schema::table('profiles', function (Blueprint $table) {
        $table->string('department')->nullable()->after('avatar_path');
        $table->string('supervisor')->nullable()->after('department');
    });
}


    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('profiles', function (Blueprint $table) {
        $table->dropColumn(['department', 'supervisor']);
    });
}

};
