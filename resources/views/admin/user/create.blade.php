@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">Create New User</h1>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-user-plus me-1"></i>
                        User Information
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST" novalidate>
                            @csrf

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
                                            value="{{ old('username') }}" required />
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
                                            value="{{ old('email') }}" required />
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
                                            value="{{ old('fname') }}" required />
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
                                            value="{{ old('lname') }}" required />
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
                                            name="password" id="password" placeholder="Password" required />
                                        <label for="password">Password</label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                            type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Confirm Password" required />
                                        <label for="password_confirmation">Confirm Password</label>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <select class="form-select @error('role') is-invalid @enderror" id="role"
                                            name="role" required>
                                            <option value="" selected disabled>Select a role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ old('role') == $role->name ? 'selected' : '' }}>
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
                                <input class="form-check-input" type="checkbox" name="verify_email" id="verify_email">
                                <label class="form-check-label" for="verify_email">
                                    Mark email as verified
                                </label>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button type="reset" class="btn btn-light">Reset</button>
                                <button type="submit" class="btn btn-primary">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-info-circle me-1"></i>
                        Tips
                    </div>
                    <div class="card-body">
                        <h5>Password Requirements</h5>
                        <ul class="small text-muted">
                            <li>At least 8 characters long</li>
                            <li>Contain at least one uppercase letter</li>
                            <li>Contain at least one lowercase letter</li>
                            <li>Contain at least one number</li>
                            <li>Contain at least one special character</li>
                        </ul>
                        <hr>
                        <h5>Username Requirements</h5>
                        <ul class="small text-muted">
                            <li>Must be unique</li>
                            <li>Can contain letters, numbers, and underscores</li>
                            <li>Cannot contain spaces or special characters</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Client-side validation could be added here
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                // Add custom validation if needed
            });
        });
    </script>
@endsection
