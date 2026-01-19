<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
{
    Schema::table('exceldata', function (Blueprint $table) {
        // phone column par unique index add karega
        $table->string('phone')->nullable(false)->unique();
    });
}

public function down(): void
{
    Schema::table('exceldata', function (Blueprint $table) {
        // rollback me phone ka unique index remove karega
        $table->dropUnique(['phone']);
    });
}

};
