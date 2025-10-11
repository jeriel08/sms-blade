<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';
    public $incrementing = false; // Since teacher_id is tied to users.id
    protected $keyType = 'int';
    protected $fillable = [
        'email',
        'password_hash',
        'role',
        'assigned_grade_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'enrolled_by_teacher_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'adviser_teacher_id');
    }
}
