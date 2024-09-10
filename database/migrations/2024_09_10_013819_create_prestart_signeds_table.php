<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prestart_signed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestart_id')->constrained()->onDelete('cascade'); // Foreign key to prestarts
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users
            $table->enum('status', ['onsite', 'sick', 'other']); // Status column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestart_signed');
    }
};
