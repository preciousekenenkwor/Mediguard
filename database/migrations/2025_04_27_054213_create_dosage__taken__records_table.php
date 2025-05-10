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
        Schema::create('dosage__taken__records', function (Blueprint $table) {
            $table->id();
            $table->string("patient_id");
            $table->string("medication_schedule_id");
            $table->string("doses_taken");
            $table->string("administered_by");
            $table->string("created_at");
            $table->timestamp("updated_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosage__taken__records');
    }
};
