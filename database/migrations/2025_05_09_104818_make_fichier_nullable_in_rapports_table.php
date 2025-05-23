<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rapports', function (Blueprint $table) {
            
            
            $table->string('file_path')->nullable()->change();
            
        });
    }

    public function down()
    {
        Schema::table('rapports', function (Blueprint $table) {
            
            $table->string('file_path')->nullable(false)->change();
        });
    }
};