<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:general,urgent,event',
            'status' => 'required|in:draft,published',
            'publish_at' => 'nullable|date'
        ]);

        if (!$validated['publish_at']) {
            $validated['publish_at'] = Carbon::now();
        }

        // Add the authenticated user's ID
        $validated['created_by'] = auth()->id();

        $announcement = Announcement::create($validated);

        return redirect()
            ->route('admin.announcements.show', $announcement)
            ->with('success', 'Announcement created successfully!');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:general,urgent,event',
            'status' => 'required|in:draft,published',
            'publish_at' => 'nullable|date'
        ]);

        if (!$validated['publish_at']) {
            $validated['publish_at'] = Carbon::now();
        }

        // Don't update created_by field
        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.show', $announcement)
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}
