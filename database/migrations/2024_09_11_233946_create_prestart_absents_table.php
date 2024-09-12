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
        Schema::create('prestart_absents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestart_id')->constrained('prestarts')->onDelete('cascade'); // Foreign key to prestarts
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->enum('status', ['onsite', 'sick', 'other']);
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestart_absents');
    }
};
