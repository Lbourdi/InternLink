<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Ce sont ces deux lignes qui manquent actuellement dans votre base :
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Lien étudiant
            $table->foreignId('offer_id')->constrained()->onDelete('cascade'); // Lien offre
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
