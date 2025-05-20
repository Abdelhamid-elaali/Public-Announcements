<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertSubscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'phone_number',
        'sms_enabled',
        'email_enabled',
        'is_active',
        'last_notification_sent_at'
    ];

    protected $casts = [
        'sms_enabled' => 'boolean',
        'email_enabled' => 'boolean',
        'is_active' => 'boolean',
        'last_notification_sent_at' => 'datetime'
    ];
}
