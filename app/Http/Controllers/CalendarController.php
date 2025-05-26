<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Announcement::where('category', 'event')
            ->where('status', 'published')
            ->get()
            ->map(function ($event) {
                $start = Carbon::parse($event->publish_at);
                $end = $start->copy()->addHours(2); // Default 2 hour duration
                
                // Check if it's an all-day event
                $isAllDay = str_contains(strtolower($event->title), 'all day');
                if ($isAllDay) {
                    $start = $start->startOfDay();
                    $end = $start->copy()->endOfDay();
                }

                // Color coding based on event type
                $color = '#3788d8'; // Default blue
                if (str_contains(strtolower($event->title), 'meeting')) {
                    $color = '#dc3545'; // Red for meetings
                } elseif (str_contains(strtolower($event->title), 'lunch')) {
                    $color = '#28a745'; // Green for lunch
                }

                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $start->format('Y-m-d H:i:s'),
                    'end' => $end->format('Y-m-d H:i:s'),
                    'allDay' => $isAllDay,
                    'url' => route('events.show', $event->id),
                    'color' => $color,
                    'textColor' => '#ffffff'
                ];
            });

        return view('calendar.index', compact('events'));
    }
}
