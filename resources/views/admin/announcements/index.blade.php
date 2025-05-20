@extends('layouts.admin')

@section('title', 'Manage Announcements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manage Announcements</h1>
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
        Create New Announcement
    </a>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Categories</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.announcements.index') }}" 
                   class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                    All Categories
                    <span class="badge bg-secondary float-end">
                        {{ $categoryCounts->sum() }}
                    </span>
                </a>
                <a href="{{ route('admin.announcements.index', ['category' => 'urgent']) }}" 
                   class="list-group-item list-group-item-action {{ request('category') === 'urgent' ? 'active' : '' }}">
                    Urgent
                    <span class="badge bg-danger float-end">
                        {{ $categoryCounts['urgent'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.announcements.index', ['category' => 'event']) }}" 
                   class="list-group-item list-group-item-action {{ request('category') === 'event' ? 'active' : '' }}">
                    Event
                    <span class="badge bg-success float-end">
                        {{ $categoryCounts['event'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.announcements.index', ['category' => 'general']) }}" 
                   class="list-group-item list-group-item-action {{ request('category') === 'general' ? 'active' : '' }}">
                    General Information
                    <span class="badge bg-info float-end">
                        {{ $categoryCounts['general'] ?? 0 }}
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Publish Date</th>
                        <th>Views</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $announcement)
                        <tr>
                            <td>{{ $announcement->title }}</td>
                            <td>
                                <span class="badge bg-{{ $announcement->category === 'urgent' ? 'danger' : 
                                                        ($announcement->category === 'event' ? 'success' : 'info') }}">
                                    {{ ucfirst($announcement->category) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $announcement->status === 'published' ? 'success' : 'warning' }}">
                                    {{ ucfirst($announcement->status) }}
                                </span>
                            </td>
                            <td>{{ $announcement->publish_at ? $announcement->publish_at->format('Y-m-d H:i') : 'Not scheduled' }}</td>
                            <td>{{ $announcement->views }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.announcements.show', $announcement) }}" 
                                       class="btn btn-sm btn-info me-1">
                                        View
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" 
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this announcement?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No announcements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
