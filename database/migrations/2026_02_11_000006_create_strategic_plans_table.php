<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('strategic_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('focus_area');
            $table->string('period')->comment('e.g., 2024-2029');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'under_review', 'archived', 'draft'])->default('draft');
            $table->integer('progress')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('strategic_plans');
    }
};
