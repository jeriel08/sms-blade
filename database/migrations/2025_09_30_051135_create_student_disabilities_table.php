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
        Schema::create('student_disabilities', function (Blueprint $table) {
            $table->unsignedBigInteger('disability_id');
            $table->unsignedBigInteger('student_id');
            $table->primary(['disability_id', 'student_id']);
            $table->timestamps();

            $table->foreign('disability_id')->references('disability_id')->on('disabilities')->onDelete('cascade');
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_disabilities');
    }
};
