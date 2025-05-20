@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Events</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        Create New Event
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Registrations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->event_date ? $event->event_date->format('Y-m-d H:i') : 'Not scheduled' }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <span class="badge bg-{{ $event->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td>{{ $event->registrations_count ?? 0 }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('events.show', $event) }}" 
                                       class="btn btn-sm btn-info me-1" target="_blank">
                                        View
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this event?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No events found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
