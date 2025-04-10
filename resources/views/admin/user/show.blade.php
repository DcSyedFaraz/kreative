@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">User Details</h1>
            <div>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit User
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-user me-1"></i>
                        User Information
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold text-secondary">User ID:</div>
                            <div class="col-md-9">{{ $user->id }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold text-secondary">Username:</div>
                            <div class="col-md-9">{{ $user->username }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold text-secondary">First Name:</div>
                            <div class="col-md-9">{{ $user->fname }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold text-secondary">Last Name:</div>
                            <div class="col-md-9">{{ $user->lname }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold text-secondary">Email:</div>
                            <div class="col-md-9">
                                {{ $user->email }}
                                @if ($user->email_verified_at)
                                    <span class="badge bg-success ms-2">Verified</span>
                                @else
                                    <span class="badge bg-warning text-dark ms-2">Not Verified</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold text-secondary">Email Verified:</div>
                            <div class="col-md-9">
                                @if ($user->email_verified_at)
                                    <span>{{ $user->email_verified_at->format('F d, Y h:i A') }}</span>
                                @else
                                    <span class="text-muted">Not verified yet</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold text-secondary">Role:</div>
                            <div class="col-md-9">
                                @if ($user->roles->count() > 0)
                                    <span class="badge bg-primary text-capitalize">{{ $user->roles->first()->name }}</span>
                                @else
                                    <span class="text-muted">No role assigned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-calendar me-1"></i>
                        Account Timeline
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Account Created</div>
                                <div>{{ $user->created_at->format('F d, Y h:i A') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-placeholder bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-sync"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Last Updated</div>
                                <div>{{ $user->updated_at->format('F d, Y h:i A') }}</div>
                            </div>
                        </div>
                        @if ($user->email_verified_at)
                            <div class="d-flex align-items-center">
                                <div class="avatar-placeholder bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Email Verified</div>
                                    <div>{{ $user->email_verified_at->format('F d, Y h:i A') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Danger Zone
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Permanently delete this user and all associated data</p>
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal">
                            <i class="fas fa-trash me-1"></i> Delete User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete user <strong>{{ $user->username }}</strong>?</p>
                    <p class="text-danger"><strong>Warning:</strong> This action cannot be undone and will permanently
                        delete all data associated with this user.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
