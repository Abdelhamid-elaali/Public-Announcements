@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $event->title }}</h4>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $event->description }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Event Details</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong><i class="fas fa-calendar"></i> Date & Time:</strong><br>
                                    {{ $event->event_date->format('M d, Y H:i') }}
                                </li>
                                @if($event->location)
                                    <li class="mb-2">
                                        <strong><i class="fas fa-map-marker-alt"></i> Location:</strong><br>
                                        {{ $event->location }}
                                    </li>
                                @endif
                                <li>
                                    <strong><i class="fas fa-users"></i> Capacity:</strong><br>
                                    {{ $event->capacity }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Registration</h5>
                            <form action="{{ route('events.register', $event) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Register for Event</button>
                            </form>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div class="mt-4 border-top pt-4">
                                <h5>Registrations</h5>
                                @if($event->registrations->isEmpty())
                                    <p>No registrations yet.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Registered At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($event->registrations as $registration)
                                                    <tr>
                                                        <td>{{ $registration->name }}</td>
                                                        <td>{{ $registration->email }}</td>
                                                        <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <div class="mt-4">
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to Events</a>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">Edit Event</a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                        Delete Event
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
