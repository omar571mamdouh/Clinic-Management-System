<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()                          // ✅ أضفها
    {
        return $this->belongsTo(Doctor::class);
    }
    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
