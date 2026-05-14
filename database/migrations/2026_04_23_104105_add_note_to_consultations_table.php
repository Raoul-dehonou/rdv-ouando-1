<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (!Schema::hasColumn('consultations', 'note')) {
                $table->decimal('note', 2, 1)->nullable()->after('prochain_rdv');
            }
            if (!Schema::hasColumn('consultations', 'type')) {
                $table->string('type')->default('consultation')->after('note');
            }
            if (!Schema::hasColumn('consultations', 'medecin_id')) {
                $table->foreignId('medecin_id')->nullable()->after('patient_id')->constrained();
            }
        });
    }

    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (Schema::hasColumn('consultations', 'note')) {
                $table->dropColumn('note');
            }
            if (Schema::hasColumn('consultations', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('consultations', 'medecin_id')) {
                $table->dropForeign(['medecin_id']);
                $table->dropColumn('medecin_id');
            }
        });
    }
};