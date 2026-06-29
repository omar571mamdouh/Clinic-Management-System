<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'visit_id',
        'drug_name',
        'dosage',
        'frequency',
        'duration',
        'notes',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}