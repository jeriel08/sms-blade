<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $primaryKey = 'section_id';
    protected $fillable = [
        'grade_level',
        'name',
        'adviser_teacher_id',
    ];

    public function adviser()
    {
        return $this->belongsTo(Teacher::class, 'adviser_teacher_id', 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'section_id');
    }
}
