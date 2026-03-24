<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('test_sessions');
            $table->string('candidate_token')->unique();
            $table->string('candidate_name');
            $table->string('candidate_email');
            $table->foreignId('assigned_problem_id')->constrained('problems');
            $table->string('status')->default('registered');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->longText('submitted_code')->nullable();
            $table->string('language')->nullable();
            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('passed_cases')->default(0);
            $table->unsignedInteger('total_cases')->default(0);
            $table->json('test_results')->nullable();
            $table->unsignedInteger('time_taken_seconds')->nullable();
            $table->timestamps();

            $table->unique(['session_id', 'candidate_email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_attempts');
    }
};
