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
        Schema::create('tournaments', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->enum('type', ['round_robin', 'elimination']);
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->enum('status', ['draft', 'upcoming', 'live', 'completed']);
    
    $table->foreignId('sport_id')->constrained()->cascadeOnDelete();
    $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
