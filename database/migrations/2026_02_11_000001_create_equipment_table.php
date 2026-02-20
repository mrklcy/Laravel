<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('equipment')) {
            Schema::create('equipment', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category'); // electronics, hvac, furniture, vehicle, tools, office
                $table->string('serial_number')->unique();
                $table->string('location')->nullable();
                $table->string('status')->default('in_use'); // in_use, under_repair, available, decommissioned
                $table->string('condition')->default('good'); // excellent, good, fair, needs_repair
                $table->string('assigned_to')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
