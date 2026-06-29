<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'gender',
        'address',
        'notes',
        'avatar',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
