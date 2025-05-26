@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="text-dark mb-4">Public Announcements</h1>
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
            <div class="card mb-4 announcement-card">
                <div class="row g-0">
                    @if($announcement->image)
                        <div class="col-md-4">
                            <div class="announcement-image">
                                <img src="{{ asset('storage/' . $announcement->image) }}" 
                                     class="img-fluid rounded-start h-100 w-100 object-fit-cover" 
                                     alt="{{ $announcement->title }}">
                            </div>
                        </div>
                    @endif
                    <div class="col-md-{{ $announcement->image ? '8' : '12' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('announcements.show', $announcement) }}" 
                                       class="text-decoration-none text-dark fw-bold">
                                        {{ $announcement->title }}
                                    </a>
                                </h5>
                                <span class="badge {{ $announcement->category === 'urgent' ? 'bg-danger' : 
                                                    ($announcement->category === 'event' ? 'bg-success' : 'general-badge') }}">
                                    {{ ucfirst($announcement->category) }}
                                </span>
                            </div>
                            
                            <p class="card-text text-muted small mb-3">
                                <i class="fas fa-clock me-1"></i>
                                Published {{ $announcement->created_at->diffForHumans() }}
                            </p>

                            <p class="card-text announcement-content mb-3">
                                {{ Str::limit(strip_tags($announcement->content), 200) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('announcements.show', $announcement) }}" 
                                   class="btn btn-primary btn-sm read-more">
                                    Read More
                                </a>
                                <div class="d-flex align-items-center">
                                    <span class="text-muted small">
                                        <i class="fas fa-eye me-1"></i> {{ $announcement->views }} views
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
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
<style>
    .general-badge {
        background-color: #6c757d;
        color: white;
    }

    .announcement-image {
        height: 200px;
        overflow: hidden;
        border-radius: 6px 0 0 6px;
        position: relative;
        background-color: #f8f9fa;
    }

    .announcement-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .announcement-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height:40%;
    }

    .announcement-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .announcement-card:hover .announcement-image img {
        transform: scale(1.05);
    }

    .announcement-card .card-body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .announcement-content {
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-title a {
        color: #333;
        font-size: 1.25rem;
        line-height: 1.4;
        transition: color 0.2s ease;
    }

    .card-title a:hover {
        color: #0056b3;
    }

    .announcement-image img {
        transition: transform 0.3s ease;
    }

    .announcement-card:hover .announcement-image img {
        transform: scale(1.05);
    }

    .card {
        border: none;
        padding-top: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 6px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .badge {
        padding: 0.5em 1em;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .card-title a {
        color: #2d3748;
        transition: color 0.2s ease;
    }

    .card-title a:hover {
        color: #25cffe;
    }

    .btn-primary {
        background: linear-gradient(135deg, #25cffe, #138496);
        border: none;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(37, 207, 254, 0.2);
    }

    .list-group-item.active {
        background-color: #25cffe;
        border-color: #25cffe;
    }
</style>
@endsection
