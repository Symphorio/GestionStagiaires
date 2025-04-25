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
        $table->string('file_path')->after('stagiaire_id');
        $table->text('comments')->nullable()->after('file_path');
        $table->timestamp('submitted_at')->nullable()->after('comments');
        $table->string('original_name')->after('file_path');
    });
}

public function down()
{
    Schema::table('rapports', function (Blueprint $table) {
        $table->dropColumn(['file_path', 'comments', 'submitted_at', 'original_name']);
    });
}
};
