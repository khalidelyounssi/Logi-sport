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
        Schema::create('matches', function (Blueprint $table) {
    $table->id();

    $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();

    $table->foreignId('participant_a_id')->constrained('participants')->cascadeOnDelete();
    $table->foreignId('participant_b_id')->constrained('participants')->cascadeOnDelete();

    $table->dateTime('match_date')->nullable();
    $table->string('location')->nullable();

    $table->integer('score_a')->nullable();
    $table->integer('score_b')->nullable();

    $table->enum('status', ['scheduled', 'in_progress', 'finished'])->default('scheduled');

    $table->foreignId('referee_id')->nullable()->constrained('users')->nullOnDelete();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_models');
    }
};
