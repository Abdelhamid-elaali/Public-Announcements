@extends('layouts.admin')

@section('title', $event->title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h1 class="card-title">{{ $event->title }}</h1>
                <span class="badge bg-{{ $event->status === 'active' ? 'success' : 'warning' }}">
                    {{ ucfirst($event->status) }}
                </span>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Event Details</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Date & Time</dt>
                        <dd class="col-sm-8">{{ $event->event_date->format('F j, Y, g:i a') }}</dd>

                        <dt class="col-sm-4">Location</dt>
                        <dd class="col-sm-8">{{ $event->location }}</dd>

                        <dt class="col-sm-4">Capacity</dt>
                        <dd class="col-sm-8">{{ $event->capacity }} participants</dd>

                        <dt class="col-sm-4">Registrations</dt>
                        <dd class="col-sm-8">{{ $event->registrations->count() }} / {{ $event->capacity }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card-text mb-4">
                <h5>Description</h5>
                {!! nl2br(e($event->description)) !!}
            </div>

            @if($event->registrations->count() > 0)
                <div class="mt-4">
                    <h5>Registrations</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->name }}</td>
                                        <td>{{ $registration->email }}</td>
                                        <td>{{ $registration->created_at->format('F j, Y, g:i a') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center text-muted mt-4">
                <div>
                    <small class="me-3">Created: {{ $event->created_at->format('F j, Y, g:i a') }}</small>
                    <small>Last Updated: {{ $event->updated_at->format('F j, Y, g:i a') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary me-2">Edit Event</a>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
