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
        Schema::create('dayendreport', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('intrested');
            $table->string('pipeline');
            $table->string('total_call');
            $table->string('call_connect');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dayendreport');
    }
};
