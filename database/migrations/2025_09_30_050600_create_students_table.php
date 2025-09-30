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
        Schema::create('students', function (Blueprint $table) {
            $table->string('lrn', 12)->primary();
            $table->string('last_name', 255)->notNullable();
            $table->string('first_name', 255)->notNullable();
            $table->string('middle_name', 255)->nullable();
            $table->string('extension_name', 10)->nullable();
            $table->date('birthdate')->notNullable();
            $table->string('place_of_birth', 100)->notNullable();
            $table->enum('sex', ['Male', 'Female'])->notNullable();
            $table->string('mother_tounge', 50)->nullable();
            $table->string('psa_birth_cert_no', 50)->nullable();
            $table->boolean('is_ip')->default(0);
            $table->string('ip_community', 100)->nullable();
            $table->unsignedBigInteger('current_address_id')->nullable()->index();
            $table->unsignedBigInteger('permanent_address_id')->nullable()->index();
            $table->boolean('is_disabled')->default(0);
            $table->timestamps();

            $table->foreign('current_address_id')->references('address_id')->on('addresses')->onDelete('set null');
            $table->foreign('permanent_address_id')->references('address_id')->on('addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
