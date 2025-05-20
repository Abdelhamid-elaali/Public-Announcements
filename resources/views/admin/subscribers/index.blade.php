@extends('layouts.admin')

@section('title', 'Alert Subscribers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Alert Subscribers</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendAlertModal">
        Send Alert
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Subscribed At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                        <tr>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $subscriber->is_active ? 'success' : 'warning' }}">
                                    {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to remove this subscriber?')">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No subscribers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $subscribers->links() }}
        </div>
    </div>
</div>

<!-- Send Alert Modal -->
<div class="modal fade" id="sendAlertModal" tabindex="-1" aria-labelledby="sendAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.alerts.send') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="sendAlertModalLabel">Send Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                               id="subject" name="subject" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                id="message" name="message" rows="5" required></textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Alert</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
