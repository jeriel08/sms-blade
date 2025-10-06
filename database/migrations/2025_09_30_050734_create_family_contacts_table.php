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
        Schema::create('family_contacts', function (Blueprint $table) {
            $table->id('contact_id');
            $table->unsignedBigInteger('student_id')->notNullable()->index();
            $table->enum('contact_type', ['Father', 'Mother', 'Guardian'])->notNullable();
            $table->string('last_name', 100)->notNullable();
            $table->string('first_name', 100)->notNullable();
            $table->string('middle_name', 100)->nullable();
            $table->string('contact_number', 50)->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_contacts');
    }
};
