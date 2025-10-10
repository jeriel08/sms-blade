<?php
//THIS IS THE ORIGINAL FILE
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $incrementing = true;
    protected $keyType = 'string';
    protected $fillable = [
        'student_id',
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
        return $this->hasMany(FamilyContact::class, 'student_id', 'student_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'student_id');
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class, 'student_disabilities', 'student_id', 'disability_id');
    }
}
