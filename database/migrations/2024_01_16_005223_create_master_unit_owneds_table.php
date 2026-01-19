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
        Schema::create('master_unit_owneds', function (Blueprint $table) {
            $table->id();
            $table->string('data_id');
            $table->string('vin2')->nullable();
            $table->string('driver_name2')->nullable();
            $table->string('driver_dob2')->nullable();
            $table->string('driver_license2')->nullable();
            $table->string('driver_license_state2')->nullable();
            $table->string('vehicle_year2')->nullable();
            $table->string('vehicle_make2')->nullable();
            $table->string('stated_value2')->nullable();
            $table->string('vin3')->nullable();
            $table->string('driver_name3')->nullable();
            $table->string('driver_dob3')->nullable();
            $table->string('driver_license3')->nullable();
            $table->string('driver_license_state3')->nullable();
            $table->string('vehicle_year3')->nullable();
            $table->string('vehicle_make3')->nullable();
            $table->string('stated_value3')->nullable();
            $table->string('vin4')->nullable();
            $table->string('driver_name4')->nullable();
            $table->string('driver_dob4')->nullable();
            $table->string('driver_license4')->nullable();
            $table->string('driver_license_state4')->nullable();
            $table->string('vehicle_year4')->nullable();
            $table->string('vehicle_make4')->nullable();
            $table->string('stated_value4')->nullable();
            $table->string('vin5')->nullable();
            $table->string('driver_name5')->nullable();
            $table->string('driver_dob5')->nullable();
            $table->string('driver_license5')->nullable();
            $table->string('driver_license_state5')->nullable();
            $table->string('vehicle_year5')->nullable();
            $table->string('vehicle_make5')->nullable();
            $table->string('stated_value5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_unit_owneds');
    }
};
