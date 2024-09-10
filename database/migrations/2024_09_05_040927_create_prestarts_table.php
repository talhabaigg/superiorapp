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
        Schema::create('prestarts', function (Blueprint $table) {
            $table->id();
            $table->date('workdate');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('foreman_id');
            $table->string('weather')->nullable();
            $table->string('weather_impact')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestarts');
    }
};
