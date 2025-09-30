<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id('enrollment_id');
            $table->string('student_lrn', 12)->notNullable();
            $table->string('school_year', 9)->notNullable();
            $table->string('grade_level', 50)->notNullable();
            $table->enum('enrollment_type', ['New', 'Old', 'Transferee', 'Returning'])->notNullable();
            $table->string('last_grade_completed', 50)->nullable();
            $table->string('last_school_year_completed', 9)->nullable();
            $table->string('last_school_attended', 255)->nullable();
            $table->string('last_school_id', 20)->nullable();
            $table->enum('semester', ['1st', '2nd'])->nullable();
            $table->string('track', 100)->nullable();
            $table->string('strand', 100)->nullable();
            $table->unsignedBigInteger('enrolled_by_teacher_id')->nullable()->index();
            $table->date('enrollment_date')->default(DB::raw('CURRENT_DATE'));
            $table->boolean('is_4ps')->default(0);
            $table->string('_4ps_household_id', 50)->nullable();
            $table->timestamps();

            $table->foreign('student_lrn')->references('lrn')->on('students')->onDelete('cascade');
            $table->foreign('enrolled_by_teacher_id')->references('teacher_id')->on('teachers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
