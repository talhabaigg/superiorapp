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
        Schema::table('prestarts', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->after('weather_impact'); // Add pdf_path column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestarts', function (Blueprint $table) {
            //
        });
    }
};
