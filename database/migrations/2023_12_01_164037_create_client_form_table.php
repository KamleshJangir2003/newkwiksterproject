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
        Schema::create('client_form', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('customer_id');
            $table->string('upload_date');
            $table->string('india_agent_name');
            $table->string('customer_name');
            $table->string('phone');
            $table->string('company_name');
            $table->string('pdf');
            $table->string('status')->nullable();
            $table->string('step')->nullable();
            $table->string('priority')->nullable();
            $table->string('pipeline_reminder')->nullable();
            $table->string('sold_amount')->nullable();
            $table->string('lost_reason')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('estimate_closing_date')->nullable();
            $table->string('estimate_closing_amount')->nullable();
            $table->string('estimate_closing_probability')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_form');
    }
};
