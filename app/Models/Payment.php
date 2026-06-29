<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    const PENDING = 'pending';
    const PAID = 'paid';
    const FAILED = 'failed';

    protected $fillable = [
        'appointment_id',
        'amount',
        'patient_id',
        'payment_method',
        'transaction_id',
        'status',
        'paid_at',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
