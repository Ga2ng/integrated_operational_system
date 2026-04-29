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
        Schema::create('certification_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certification_program_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->string('type', 20)->default('text'); // text, file
            $table->boolean('is_required')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_requirements');
    }
};
