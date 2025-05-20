<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone_number',
        'sms_enabled',
        'email_enabled'
    ];

    protected $casts = [
        'sms_enabled' => 'boolean',
        'email_enabled' => 'boolean'
    ];
}
