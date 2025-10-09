<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    //
    protected $table = 'disabilities';
    protected $primaryKey = 'disability_id';
    protected $fillable = [
        'name',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_disabilities', 'disability_id', 'student_id');
    }
}
