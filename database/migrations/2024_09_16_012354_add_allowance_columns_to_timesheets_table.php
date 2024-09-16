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
        Schema::table('timesheets', function (Blueprint $table) {
            $table->boolean('is_approved')->nullable()->after('notes');
            $table->boolean('laser_allowance')->nullable()->after('is_approved');
            $table->decimal('marker_allowance', 5, 2)->nullable()->after('laser_allowance');
            $table->decimal('insulation_allowance', 5, 2)->nullable()->after('marker_allowance');
            $table->unsignedBigInteger('created_by')->nullable()->after('insulation_allowance');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');

            // Optionally, add foreign key constraints if you have a users table
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timesheets', function (Blueprint $table) {
            // Drop foreign key constraints before dropping columns
            // $table->dropForeign(['created_by']);
            // $table->dropForeign(['updated_by']);

            // Drop columns if rolling back
            $table->dropColumn(['is_approved', 'laser_allowance', 'marker_allowance', 'insulation_allowance', 'created_by', 'updated_by']);
        });
    }
};
