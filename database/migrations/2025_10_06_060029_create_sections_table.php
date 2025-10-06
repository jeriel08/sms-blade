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
        Schema::create('sections', function (Blueprint $table) {
            $table->id('section_id');
            $table->string('grade_level', 50)->notNullable();
            $table->string('name', 100)->notNullable();
            $table->unsignedBigInteger('adviser_teacher_id')->nullable()->index();
            $table->timestamps();

            $table->unique(['grade_level', 'name']);
            $table->foreign('adviser_teacher_id')->references('teacher_id')->on('teachers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
