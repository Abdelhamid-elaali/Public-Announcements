@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Events</h4>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Create New Event</a>
                        @endif
                    @endauth
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($events->isEmpty())
                        <p class="text-center">No events available.</p>
                    @else
                        <div class="row">
                            @foreach($events as $event)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $event->title }}</h5>
                                            <p class="card-text">{{ Str::limit($event->content, 150) }}</p>
                                            @if($event->event_date)
                                                <div class="mb-2">
                                                    <strong><i class="fas fa-calendar"></i> Date & Time:</strong> 
                                                    {{ $event->event_date->format('M d, Y H:i') }}
                                                </div>
                                            @endif
                                            @if($event->location)
                                                <div class="mb-2">
                                                    <strong><i class="fas fa-map-marker-alt"></i> Location:</strong> 
                                                    {{ $event->location }}
                                                </div>
                                            @endif
                                            @if($event->max_participants)
                                                <div class="mb-2">
                                                    <strong><i class="fas fa-users"></i> Capacity:</strong> 
                                                    {{ $event->max_participants }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="{{ route('events.show', $event) }}" class="btn btn-info">View Details</a>
                                                @auth
                                                    @if(auth()->user()->role === 'admin')
                                                        <div>
                                                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">Edit</a>
                                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
