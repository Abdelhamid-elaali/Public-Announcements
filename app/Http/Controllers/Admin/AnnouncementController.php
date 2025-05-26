<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        // Get category counts
        $categoryCounts = Announcement::query()
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        $query = Announcement::query();

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search by title or content if search term provided
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        // Get results with latest first
        $announcements = $query->orderBy('created_at', 'desc')
                              ->paginate(10)
                              ->withQueryString();

        return view('admin.announcements.index', compact('announcements', 'categoryCounts'));
    }

    public function show(Announcement $announcement)
    {
        // If it's an event, load the registrations
        if ($announcement->category === 'event') {
            $registrations = $announcement->registrations()
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('admin.announcements.show', compact('announcement', 'registrations'));
        }

        return view('admin.announcements.show', compact('announcement'));
    }
}
