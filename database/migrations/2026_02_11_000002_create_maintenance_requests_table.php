<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique(); // e.g. #MNT-2026-001
            $table->string('issue');
            $table->string('location');
            $table->string('priority')->default('medium'); // low, medium, high
            $table->string('status')->default('pending'); // pending, in_progress, completed, on_hold
            $table->string('reporter')->nullable();
            $table->text('description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->date('target_date')->nullable();
            $table->text('assigned_notes')->nullable();
            $table->text('progress_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
