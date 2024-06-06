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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('abbreviated_project_name')->nullable();
            $table->string('subsidiary'); // Regular string field for subsidiary
            $table->string('project_number');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('timezone');
            $table->decimal('average_hourly_rate', 8, 2);
            $table->integer('estimated_hours')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('completed')->default(false);
            $table->boolean('daily_qr_code')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
