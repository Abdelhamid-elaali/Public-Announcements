@extends('layouts.admin')

@section('title', 'Manage Announcements')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="text-dark mb-4">Manage Announcements</h1>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary w-100">
            <i class="fas fa-plus-circle me-2"></i> Create New Announcement
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Categories</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.announcements.index') }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !request('category') ? 'active' : '' }}">
                    <span>All Categories</span>
                    <span class="badge rounded-pill bg-primary">
                        {{ $categoryCounts->sum() }}
                    </span>
                </a>
                @foreach($categoryCounts as $category => $count)
                    <a href="{{ route('admin.announcements.index', ['category' => $category]) }}" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('category') === $category ? 'active' : '' }}">
                        <span>{{ ucfirst($category) }}</span>
                        <span class="badge rounded-pill {{ $category === 'urgent' ? 'bg-danger' : ($category === 'event' ? 'bg-success' : 'bg-secondary') }}">{{ $count }}</span>
                    </a>
                @endforeach
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
                        <th>Created Date</th>
                        <th>Views</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $announcement)
                        <tr>
                            <td>{{ $announcement->title }}</td>
                            <td>
                                <span class="badge {{ $announcement->category === 'urgent' ? 'bg-danger' : 
                                                        ($announcement->category === 'event' ? 'bg-success' : ($announcement->category === 'general' ? 'bg-secondary' : 'bg-info')) }}">
                                    {{ ucfirst($announcement->category) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $announcement->status === 'published' ? 'success' : 'warning' }}">
                                    {{ ucfirst($announcement->status) }}
                                </span>
                            </td>
                            <td>{{ $announcement->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $announcement->views }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.announcements.show', $announcement) }}" 
                                       class="btn action-btn btn-outline-info" data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" 
                                       class="btn action-btn btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn action-btn btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this announcement?')"
                                                data-bs-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash"></i>
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
<style>
    .list-group-item.active {
        background-color: #25cffe;
        border-color: #25cffe;
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
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
