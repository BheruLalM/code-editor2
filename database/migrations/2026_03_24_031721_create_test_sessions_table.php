<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_token')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('difficulty_filter')->default('any');
            $table->unsignedInteger('time_limit_minutes')->default(60);
            $table->boolean('is_active')->default(true);
            $table->dateTime('expires_at')->nullable();
            $table->unsignedInteger('max_attempts')->default(1);
            $table->foreignId('created_by')->constrained('admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_sessions');
    }
};
