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
        Schema::create('certification_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certification_participant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('certification_requirement_id')->constrained()->cascadeOnDelete();
            $table->text('answer_text')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
            
            $table->unique(['certification_participant_id', 'certification_requirement_id'], 'cert_answer_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_answers');
    }
};
