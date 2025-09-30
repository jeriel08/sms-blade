<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyContact extends Model
{
    //
    protected $table = 'family_contacts';
    protected $primaryKey = 'contact_id';
    protected $fillable = [
        'student_lrn',
        'contact_type',
        'last_name',
        'first_name',
        'middle_name',
        'contact_number',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_lrn', 'lrn');
    }
}
