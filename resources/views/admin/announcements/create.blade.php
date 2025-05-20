@extends('layouts.admin')

@section('title', 'Create Announcement')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Create New Announcement</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Select a category</option>
                                <option value="urgent" {{ old('category') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="event" {{ old('category') === 'event' ? 'selected' : '' }}>Event</option>
                                <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General Information</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image (Optional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Upload an image to be displayed with the announcement. Supported formats: JPG, PNG, GIF.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="publish_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control @error('publish_at') is-invalid @enderror" 
                                   id="publish_at" name="publish_at" value="{{ old('publish_at') }}">
                            @error('publish_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Leave empty to publish immediately when status is set to published.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Announcement</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection
