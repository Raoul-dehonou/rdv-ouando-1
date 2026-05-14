<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Supprimer l'ancienne table si elle existe
        Schema::dropIfExists('consultations');

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('rendezvous_id')->constrained('rendez_vous')->onDelete('cascade');
            $table->text('diagnostic');
            $table->text('prescription')->nullable();
            $table->text('notes')->nullable();
            $table->date('prochain_rdv')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultations');
    }
};