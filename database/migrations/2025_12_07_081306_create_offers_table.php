<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('offers', function (Blueprint $table) {
            $table->id(); // [cite: 495]
            $table->string('title'); // [cite: 496]
            $table->string('company_name');
            $table->text('description'); // text n'est pas explicite dans le PDF mais c'est du standard SQL, sinon mettez string
            // Clé étrangère pour lier à l'utilisateur qui crée l'offre
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete(); // [cite: 549]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
