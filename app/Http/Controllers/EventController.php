<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Announcement::where('status', 'published')
            ->where('category', 'event')
            ->where(function($q) {
                $q->where('publish_at', '<=', now())
                  ->orWhereNull('publish_at');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('events.index', compact('events'));
    }

    public function show($id)
    {
        $event = Announcement::where('category', 'event')
            ->where('status', 'published')
            ->findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function register(Request $request, $id)
    {
        $event = Announcement::where('category', 'event')
            ->where('status', 'published')
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        if ($event->registrations()->count() >= $event->max_participants) {
            return back()->with('error', 'Event is fully booked.');
        }

        $event->registrations()->create($validated);

        return back()->with('success', 'Successfully registered for the event.');
    }

    public function adminIndex()
    {
        $events = Announcement::where('category', 'event')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function adminShow($id)
    {
        $event = Announcement::where('category', 'event')->findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'publish_at' => 'nullable|date',
            'max_participants' => 'required|integer|min:1'
        ]);

        $validated['category'] = 'event';
        $validated['created_by'] = auth()->id();
        
        if ($validated['status'] === 'published' && empty($validated['publish_at'])) {
            $validated['publish_at'] = now();
        }
        
        Announcement::create($validated);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit($id)
    {
        $event = Announcement::where('category', 'event')->findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Announcement::where('category', 'event')->findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'publish_at' => 'nullable|date',
            'max_participants' => 'required|integer|min:1'
        ]);
        
        $event->update($validated);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Announcement $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
