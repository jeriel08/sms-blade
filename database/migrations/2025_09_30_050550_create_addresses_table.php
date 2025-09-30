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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('address_id');
            $table->string('house_no', 50)->nullable();
            $table->string('street_name', 100)->nullable();
            $table->string('barangay', 100)->notNullable();
            $table->string('municipality_city', 100)->notNullable();
            $table->string('province', 100)->notNullable();
            $table->string('country', 100)->default('Philippines');
            $table->string('zip_code', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
