<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    //
    protected $table = 'enrollments';
    protected $primaryKey = 'enrollment_id';
    protected $fillable = [
        'student_id',
        'school_year',
        'grade_level',
        'enrollment_type',
        'last_grade_completed',
        'last_school_year_completed',
        'last_school_attended',
        'last_school_id',
        'semester',
        'track',
        'strand',
        'enrolled_by_teacher_id',
        'enrollment_date',
        'is_4ps',
        '_4ps_household_id',
        'status',
        'section_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'enrolled_by_teacher_id', 'teacher_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'section_id');
    }
}
