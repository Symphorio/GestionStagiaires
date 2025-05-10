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
    $rapports = \App\Models\Rapport::all();
    
    foreach ($rapports as $rapport) {
        $oldPath = storage_path('app/'.$rapport->file_path);
        $newPath = storage_path('app/public/rapports/'.basename($rapport->file_path));
        
        if (file_exists($oldPath)) {
            rename($oldPath, $newPath);
            $rapport->file_path = 'rapports/'.basename($rapport->file_path);
            $rapport->save();
        }
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_folder', function (Blueprint $table) {
            //
        });
    }
};
