<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('difficulty')->default('easy');
            $table->text('description');
            $table->json('starter_code')->nullable();
            $table->json('visible_test_cases');
            $table->json('hidden_test_cases');
            $table->unsignedInteger('time_limit_seconds')->default(2);
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('problems');
    }
};
