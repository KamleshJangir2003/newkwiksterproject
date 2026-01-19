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
        Schema::create('breaks', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('dinner_break');
            $table->string('tea_break');
            $table->string('short_break');
            $table->string('training_break');
            $table->string('meeting_break');
            $table->string('hours');
            $table->string('minutes');
            $table->string('seconds');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breaks');
    }
};
