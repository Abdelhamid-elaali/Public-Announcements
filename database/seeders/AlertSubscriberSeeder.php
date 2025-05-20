<?php

namespace Database\Seeders;

use App\Models\AlertSubscriber;
use Illuminate\Database\Seeder;

class AlertSubscriberSeeder extends Seeder
{
    public function run(): void
    {
        // Create some test subscribers
        $subscribers = [
            [
                'email' => 'test1@example.com',
                'phone_number' => '+1234567890',
                'sms_enabled' => true,
                'email_enabled' => true,
            ],
            [
                'email' => 'test2@example.com',
                'phone_number' => null,
                'sms_enabled' => false,
                'email_enabled' => true,
            ],
            [
                'email' => 'test3@example.com',
                'phone_number' => '+0987654321',
                'sms_enabled' => true,
                'email_enabled' => false,
            ],
        ];

        foreach ($subscribers as $subscriber) {
            AlertSubscriber::create($subscriber);
        }
    }
}
