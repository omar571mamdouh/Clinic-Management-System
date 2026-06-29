<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'visit_id',
        'file_path',
        'type',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}