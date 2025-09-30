<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';
    protected $primaryKey = 'lrn';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'lrn',
        'last_name',
        'first_name',
        'middle_name',
        'extension_name',
        'birthdate',
        'place_of_birth',
        'sex',
        'mother_tounge',
        'psa_birth_cert_no',
        'is_ip',
        'ip_community',
        'current_address_id',
        'permanent_address_id',
        'is_disabled',
    ];

    public function currentAddress()
    {
        return $this->belongsTo(Address::class, 'current_address_id', 'address_id');
    }

    public function permanentAddress()
    {
        return $this->belongsTo(Address::class, 'permanent_address_id', 'address_id');
    }

    public function familyContacts()
    {
        return $this->hasMany(FamilyContact::class, 'student_lrn', 'lrn');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_lrn', 'lrn');
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class, 'student_disabilities', 'student_lrn', 'disability_id');
    }
}
