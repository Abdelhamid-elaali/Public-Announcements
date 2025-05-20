<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'capacity',
        'status',
        'created_by'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
