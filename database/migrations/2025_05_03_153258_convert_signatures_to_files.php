<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\DemandeStage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $demandes = DemandeStage::whereNotNull('signature')->get();
        
        foreach ($demandes as $demande) {
            if ($demande->signature) {
                $fileName = 'signatures/legacy_'.$demande->id.'.png';
                Storage::disk('public')->put($fileName, $demande->signature);
                $demande->update(['signature_path' => $fileName]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            //
        });
    }
};
