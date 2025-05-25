@extends('layouts.admin')

@section('title', 'Edit Announcement')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Edit Announcement</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $announcement->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="5" required>{{ old('content', $announcement->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required onchange="toggleCapacityField()">
                                <option value="">Select a category</option>
                                <option value="urgent" {{ old('category', $announcement->category) === 'urgent' ? 'selected' : '' }}>
                                    Urgent
                                </option>
                                <option value="event" {{ old('category', $announcement->category) === 'event' ? 'selected' : '' }}>
                                    Event
                                </option>
                                <option value="general" {{ old('category', $announcement->category) === 'general' ? 'selected' : '' }}>
                                    General Information
                                </option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="capacityField" style="display: none;">
                            <label for="max_participants" class="form-label">Event Capacity</label>
                            <input type="number" class="form-control @error('max_participants') is-invalid @enderror" 
                                   id="max_participants" name="max_participants" 
                                   value="{{ old('max_participants', $announcement->max_participants) }}" min="1">
                            <div class="form-text">Maximum number of participants allowed for this event.</div>
                            @error('max_participants')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status', $announcement->status) === 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>
                                <option value="published" {{ old('status', $announcement->status) === 'published' ? 'selected' : '' }}>
                                    Published
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            @if($announcement->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $announcement->image) }}" 
                                         class="img-thumbnail" 
                                         style="max-height: 200px" 
                                         alt="Current image for {{ $announcement->title }}">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Upload a new image to replace the current one. Leave empty to keep the current image.
                                Supported formats: JPG, PNG, GIF.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="publish_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control @error('publish_at') is-invalid @enderror" 
                                   id="publish_at" name="publish_at" 
                                   value="{{ old('publish_at', $announcement->publish_at ? $announcement->publish_at->format('Y-m-d\TH:i') : '') }}">
                            @error('publish_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Leave empty to publish immediately when status is set to published.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Announcement</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleCapacityField() {
        const category = document.getElementById('category').value;
        const capacityField = document.getElementById('capacityField');
        
        if (category === 'event') {
            capacityField.style.display = 'block';
            document.getElementById('max_participants').required = true;
        } else {
            capacityField.style.display = 'none';
            document.getElementById('max_participants').required = false;
        }
    }

    // Run on page load to handle initial state
    document.addEventListener('DOMContentLoaded', function() {
        toggleCapacityField();
    });
</script>
@endpush
