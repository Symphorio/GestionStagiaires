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
        Schema::table('memoires', function (Blueprint $table) {
            $table->timestamp('review_requested_at')->nullable();
            $table->timestamp('resubmitted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->dropColumn(['review_requested_at', 'resubmitted_at']);
        });
    }
};
