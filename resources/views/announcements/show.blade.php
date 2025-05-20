@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $announcement->title }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h1 class="card-title">{{ $announcement->title }}</h1>
                <span class="badge bg-{{ $announcement->category === 'urgent' ? 'danger' : 
                                        ($announcement->category === 'event' ? 'success' : 'info') }}">
                    {{ ucfirst($announcement->category) }}
                </span>
            </div>

            @if($announcement->image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $announcement->image) }}" 
                         class="img-fluid rounded" 
                         alt="Image for {{ $announcement->title }}">
                </div>
            @endif

            <div class="card-text mb-4">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            <div class="d-flex justify-content-between align-items-center text-muted">
                <small>Published {{ $announcement->publish_at->format('F j, Y, g:i a') }}</small>
                <small>Views: {{ $announcement->views }}</small>
            </div>
        </div>
    </div>

    @if($announcement->category === 'urgent')
        <div class="alert alert-danger mt-4">
            <h4 class="alert-heading">Important Notice!</h4>
            <p>This is an urgent announcement. Please take note of the information provided above.</p>
            <hr>
            <p class="mb-0">
                Make sure you're subscribed to our alert system to receive immediate notifications for urgent announcements.
            </p>
        </div>
    @endif
</div>
@endsection
