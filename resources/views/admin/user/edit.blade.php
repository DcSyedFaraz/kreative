@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">Edit User</h1>
            <div>
                <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-info me-2">
                    <i class="fas fa-eye me-1"></i> View Details
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-user-edit me-1"></i>
                        Edit User Information
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                    <strong>Error!</strong> Please check the form below for errors.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control @error('username') is-invalid @enderror" type="text"
                                            name="username" id="username" placeholder="Username"
                                            value="{{ old('username', $user->username) }}" required />
                                        <label for="username">Username</label>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            name="email" id="email" placeholder="Email Address"
                                            value="{{ old('email', $user->email) }}" required />
                                        <label for="email">Email Address</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control @error('fname') is-invalid @enderror" type="text"
                                            name="fname" id="fname" placeholder="First Name"
                                            value="{{ old('fname', $user->fname) }}" required />
                                        <label for="fname">First Name</label>
                                        @error('fname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control @error('lname') is-invalid @enderror" type="text"
                                            name="lname" id="lname" placeholder="Last Name"
                                            value="{{ old('lname', $user->lname) }}" required />
                                        <label for="lname">Last Name</label>
                                        @error('lname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password"
                                            name="password" id="password" placeholder="New Password" />
                                        <label for="password">New Password (leave blank to keep current)</label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                            type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Confirm New Password" />
                                        <label for="password_confirmation">Confirm New Password</label>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <select class="form-select text-capitalize @error('role') is-invalid @enderror" id="role"
                                            name="role" required>
                                            <option value="" disabled>Select a role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}" class="text-capitalize"
                                                    {{ old('role', $userRole?->name ?? '') == $role->name ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="role">User Role</label>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="verify_email" id="verify_email"
                                    {{ $user->email_verified_at ? 'checked' : '' }}>
                                <label class="form-check-label" for="verify_email">
                                    Email verified
                                </label>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-clock me-1"></i>
                        Account Details
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small text-muted">User ID</label>
                            <div>{{ $user->id }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Account Created</label>
                            <div>{{ $user->created_at->format('F d, Y h:i A') }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Last Updated</label>
                            <div>{{ $user->updated_at->format('F d, Y h:i A') }}</div>
                        </div>
                        <div>
                            <label class="small text-muted">Email Verification Status</label>
                            <div>
                                @if ($user->email_verified_at)
                                    <span class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Verified on {{ $user->email_verified_at->format('F d, Y h:i A') }}
                                    </span>
                                @else
                                    <span class="text-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Not verified
                                    </span>
                                @endif
                            </div>
                        </div>
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
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
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
