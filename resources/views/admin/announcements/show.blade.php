@extends('layouts.admin')

@section('title', $announcement->title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.announcements.index') }}">Announcements</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $announcement->title }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h1 class="card-title">{{ $announcement->title }}</h1>
                <div>
                    <span class="badge bg-{{ $announcement->category === 'urgent' ? 'danger' : 
                                        ($announcement->category === 'event' ? 'success' : 'info') }} me-2">
                        {{ ucfirst($announcement->category) }}
                    </span>
                    <span class="badge bg-{{ $announcement->status === 'published' ? 'success' : 'warning' }}">
                        {{ ucfirst($announcement->status) }}
                    </span>
                </div>
            </div>

            @if($announcement->image)
                <div class="w-full h-64 overflow-hidden rounded-lg mb-4">
                    <img src="{{ asset('storage/' . $announcement->image) }}" 
                         alt="Image for {{ $announcement->title }}" 
                         class="w-50 h-50 object-cover">
                </div>
            @endif

            <div class="card-text mb-4">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            <div class="d-flex justify-content-between align-items-center text-muted">
                <div>
                    <small class="me-3">Created: {{ $announcement->created_at->format('F j, Y, g:i a') }}</small>
                    <small class="me-3">Last Updated: {{ $announcement->updated_at->format('F j, Y, g:i a') }}</small>
                    @if($announcement->publish_at)
                        <small>Scheduled: {{ $announcement->publish_at->format('F j, Y, g:i a') }}</small>
                    @endif
                </div>
                <small>Views: {{ $announcement->views }}</small>
            </div>

            @if($announcement->category === 'event')
                <hr>
                <div class="mt-4">
                    <h4 class="mb-3">Event Registrations</h4>
                    @if(isset($registrations) && $registrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registered At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $index => $registration)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $registration->name }}</td>
                                            <td>{{ $registration->email }}</td>
                                            <td>{{ $registration->created_at->format('F j, Y, g:i a') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 text-muted">
                            <small>Total Registrations: {{ $registrations->count() }}</small>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No registrations yet for this event.
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-primary me-2">Edit</a>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
