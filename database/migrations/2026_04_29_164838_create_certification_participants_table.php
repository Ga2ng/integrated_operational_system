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
        Schema::create('certification_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certification_program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status', 30)->default('pending'); // pending, submitted, reviewed, approved, rejected
            $table->timestamp('submitted_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->unique(['certification_program_id', 'participant_user_id'], 'cert_part_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_participants');
    }
};
