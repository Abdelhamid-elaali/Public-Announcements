<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Create some test announcements
        $announcements = [
            [
                'title' => 'Welcome to Our Platform',
                'content' => 'Welcome to our new public announcements platform. Here you will find all the latest updates and news.',
                'category' => 'general',
                'status' => 'published',
                'publish_at' => now(),
                'created_by' => $admin->id
            ],
            [
                'title' => 'Important System Maintenance',
                'content' => 'The system will undergo maintenance this weekend. Please expect some downtime.',
                'category' => 'urgent',
                'status' => 'published',
                'publish_at' => now()->addDays(2),
                'created_by' => $admin->id
            ],
            [
                'title' => 'New Features Coming Soon',
                'content' => 'We are working on exciting new features that will be released next month.',
                'category' => 'general',
                'status' => 'draft',
                'publish_at' => null,
                'created_by' => $admin->id
            ]
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
