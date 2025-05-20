@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Public Announcements</h1>
    </div>
    <div class="col-md-4">
        <form action="{{ route('announcements.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search announcements..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Categories</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('announcements.index') }}" 
                   class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                    All Categories
                </a>
                <a href="{{ route('announcements.index', ['category' => 'urgent']) }}" 
                   class="list-group-item list-group-item-action {{ request('category') === 'urgent' ? 'active' : '' }}">
                    Urgent
                </a>
                <a href="{{ route('announcements.index', ['category' => 'event']) }}" 
                   class="list-group-item list-group-item-action {{ request('category') === 'event' ? 'active' : '' }}">
                    Event
                </a>
                <a href="{{ route('announcements.index', ['category' => 'general']) }}" 
                   class="list-group-item list-group-item-action {{ request('category') === 'general' ? 'active' : '' }}">
                    General Information
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Subscribe to Alerts</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('alerts.subscribe') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number (Optional)</label>
                        <input type="tel" class="form-control" id="phone" name="phone_number">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="sms_enabled" name="sms_enabled" value="1">
                            <label class="form-check-label" for="sms_enabled">Receive SMS Alerts</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        @forelse($announcements as $announcement)
            <div class="card mb-3">
                <div class="row g-0">
                    @if($announcement->image)
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $announcement->image) }}" 
                                 class="img-fluid rounded-start" 
                                 alt="Image for {{ $announcement->title }}">
                        </div>
                    @endif
                    <div class="col-md-{{ $announcement->image ? '8' : '12' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class="card-title">
                            <a href="{{ route('announcements.show', $announcement) }}" class="text-decoration-none">
                                {{ $announcement->title }}
                            </a>
                        </h5>
                        <span class="badge bg-{{ $announcement->category === 'urgent' ? 'danger' : 
                                                ($announcement->category === 'event' ? 'success' : 'info') }}">
                            {{ ucfirst($announcement->category) }}
                        </span>
                    </div>
                    <p class="card-text">{{ Str::limit($announcement->content, 200) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Published {{ $announcement->publish_at ? $announcement->publish_at->diffForHumans() : 'recently' }}
                        </small>
                        <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-sm btn-primary">
                            Read More
                        </a>
                    </div>
                </div>
                @if($announcement->image)
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="alert alert-info">
                No announcements found.
            </div>
        @endforelse

        <div class="d-flex justify-content-center">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection
