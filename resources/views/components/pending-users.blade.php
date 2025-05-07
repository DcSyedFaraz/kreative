<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-primary">
                <i class="fas fa-user-clock me-2"></i>Pending User Registrations
            </h2>
            <span class="badge bg-primary rounded-pill">
                {{ $users->count() }} Pending
            </span>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($users->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">There are no pending registrations at this time.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col"><i class="fas fa-user me-2"></i>Username</th>
                                <th scope="col"><i class="fas fa-envelope me-2"></i>Email</th>
                                <th scope="col"><i class="fas fa-calendar me-2"></i>Requested</th>
                                <th scope="col" class="text-end"><i class="fas fa-tasks me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-initials bg-primary text-white me-2">
                                                {{ strtoupper(substr($user->username, 0, 2)) }}
                                            </div>
                                            <span>{{ $user->username }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ route('admin.approve', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check me-1"></i> Approve
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $user->id }}">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        </div>

                                        <!-- Reject Confirmation Modal -->
                                        <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="rejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel">Confirm Rejection
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to reject the registration request from
                                                            <strong>{{ $user->username }}</strong>?
                                                        </p>
                                                        <p class="text-muted">An email will be sent to notify the user.
                                                        </p>

                                                        <form action="{{ route('admin.reject', $user->id) }}"
                                                            method="POST" id="rejectForm{{ $user->id }}">
                                                            @csrf
                                                            {{-- <div class="mb-3">
                                                                <label for="rejection_reason"
                                                                    class="form-label">Rejection Reason
                                                                    (Optional)
                                                                </label>
                                                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                                                    placeholder="Provide a reason for rejection..."></textarea>
                                                            </div> --}}
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" form="rejectForm{{ $user->id }}"
                                                            class="btn btn-danger">Confirm Rejection</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted mb-0">
                        <small>Last updated: {{ now()->format('M d, Y H:i') }}</small>
                    </p>
                    <div>
                        @if ($users->hasPages())
                            {{ $users->links() }}
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .avatar-initials {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Add subtle hover effect on table rows */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transition: background-color 0.2s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        th,
        td {
            padding: 0.5rem 0.75rem;
        }
    }
</style>

@section('scripts')
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });
    </script>
@endsection
