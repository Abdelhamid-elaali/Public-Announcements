<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();

        // Filter by status
        $query->where('status', 'published');

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

        // Get results
        $announcements = $query->orderBy('created_at', 'desc')
                              ->paginate(10)
                              ->withQueryString();
        
        return view('announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        // If user is not logged in or not an admin/supervisor
        if (!auth()->check() || !auth()->user()->hasRole(['admin', 'supervisor'])) {
            if ($announcement->status !== 'published' || 
                ($announcement->publish_at && $announcement->publish_at > now())) {
                abort(404);
            }
        }

        $announcement->increment('views');
        return view('announcements.show', compact('announcement'));
    }

    public function adminIndex(Request $request)
    {
        $query = Announcement::query();

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Get results
        $announcements = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Get category counts for the sidebar
        $categoryCounts = Announcement::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        return view('admin.announcements.index', compact('announcements', 'categoryCounts'));
    }

    public function adminShow(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'status' => 'required|in:draft,published',
            'publish_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $currentTime = now();
        $validated['created_by'] = auth()->id();
        
        // Set created_at and publish_at to current time for published announcements
        if ($validated['status'] === 'published') {
            $validated['publish_at'] = $currentTime;
            $announcement = new Announcement($validated);
            $announcement->created_at = $currentTime;
            $announcement->updated_at = $currentTime;
        } else {
            $announcement = new Announcement($validated);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/announcements');
            $announcement->image = 'announcements/' . basename($imagePath);
            
            // Ensure the file is publicly accessible
            Storage::disk('public')->setVisibility('announcements/' . basename($imagePath), 'public');
        }
        
        $announcement->save();
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'status' => 'required|in:draft,published',
            'publish_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $currentTime = now();
        
        // If changing to published status, update timestamps
        if ($validated['status'] === 'published' && $announcement->status !== 'published') {
            $validated['publish_at'] = $currentTime;
            $announcement->created_at = $currentTime;
            $announcement->updated_at = $currentTime;
        }

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $imagePath = $request->file('image')->store('public/announcements');
            $validated['image'] = 'announcements/' . basename($imagePath);
            
            // Ensure the file is publicly accessible
            Storage::disk('public')->setVisibility('announcements/' . basename($imagePath), 'public');
        }
        
        $announcement->update($validated);
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        $announcement->delete();
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
