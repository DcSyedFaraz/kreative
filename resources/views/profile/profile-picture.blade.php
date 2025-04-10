@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Profile Picture</span>
                        <a href="{{ route('profile.index') }}" class="btn btn-sm btn-secondary">Back to Profile</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="text-center mb-4">
                            @if ($user->profile && $user->profile->profile_picture)
                                <img src="{{ asset('storage/profile-pictures/' . $user->profile->profile_picture) }}"
                                    alt="Profile Picture" class="img-fluid rounded-circle" style="max-width: 200px;">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Picture"
                                    class="img-fluid rounded-circle" style="max-width: 200px;">
                            @endif
                        </div>

                        <form action="{{ route('profile.update-profile-picture') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Choose new profile picture</label>
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror"
                                    id="profile_picture" name="profile_picture">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Allowed formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</div>
                            </div>

                            <button type="submit" class="btn btn-primary">Upload New Picture</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
