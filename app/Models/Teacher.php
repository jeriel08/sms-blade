<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';
    public $incrementing = false; // Since teacher_id is tied to users.id
    protected $keyType = 'int';
    protected $fillable = [
        'teacher_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'assigned_grade_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'enrolled_by_teacher_id', 'teacher_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'adviser_teacher_id', 'teacher_id');
    }

    // Get the advisory section for this teacher
    public function advisorySection()
    {
        return $this->hasOne(Section::class, 'adviser_teacher_id', 'teacher_id');
    }
}