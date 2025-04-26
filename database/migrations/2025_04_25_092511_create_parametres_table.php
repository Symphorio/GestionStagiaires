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
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id')->constrained()->onDelete('cascade');
            $table->boolean('notifications')->default(true);
            $table->boolean('email_alerts')->default(true);
            $table->boolean('dark_mode')->default(false);
            $table->string('language', 2)->default('fr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametres');
    }
};
