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
        Schema::create('alertes_urgences', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('telephone');
            $table->text('description');
            $table->boolean('traitee')->default(false);
            $table->timestamp('traitee_le')->nullable();
            $table->unsignedBigInteger('traitee_par')->nullable();
            $table->timestamps();
            
            // Optionnel : clé étrangère vers la table users
            // $table->foreign('traitee_par')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertes_urgences');
    }
};