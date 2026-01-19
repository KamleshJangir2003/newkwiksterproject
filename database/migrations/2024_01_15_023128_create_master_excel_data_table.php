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
        Schema::create('master_excel_data', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('company_rep1');
            $table->string('business_address');
            $table->string('business_city');
            $table->string('business_state');
            $table->string('business_zip');
            $table->string('dot');
            $table->string('mc_docket');
            $table->string('vin')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_dob')->nullable();
            $table->string('driver_licence')->nullable();
            $table->string('driver_licence_state')->nullable();
            $table->string('unit_owned')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('stated_value')->nullable();
            $table->enum('status', ['Y', 'N']);
            $table->string('form_status')->nullable();
            $table->string('insured_date')->nullable();
            $table->string('click_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_excel_data');
    }
};
