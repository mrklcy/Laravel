<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('rooms')->default(0);
            $table->integer('floors')->default(1);
            $table->integer('year_built')->nullable();
            $table->decimal('total_area', 10, 2)->nullable();
            $table->string('status')->default('active'); // active, maintenance, inactive
            $table->string('manager')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
