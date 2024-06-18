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
        Schema::create('building_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->string('description');
            $table->string('wages_assigned');
            $table->string('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_tasks');
    }
};
