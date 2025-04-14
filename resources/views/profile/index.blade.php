@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile Dashboard</div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                @if ($user->profile && $user->profile->profile_picture)
                                    <img src="{{ asset('storage/profile-pictures/' . $user->profile->profile_picture) }}"
                                        alt="Profile Picture" class="img-fluid rounded-circle">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Picture"
                                        class="img-fluid rounded-circle">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h2>{{ $user->profile->display_name ?? $user->name }}</h2>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="list-group">
                            <a href="{{ route('profile.personal-info') }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Personal Information</h5>
                                    <small><i class="fas fa-chevron-right"></i></small>
                                </div>
                                <p class="mb-1">Update your name, email, phone number, and address</p>
                            </a>

                            <a href="{{ route('profile.profile-picture') }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Profile Picture</h5>
                                    <small><i class="fas fa-chevron-right"></i></small>
                                </div>
                                <p class="mb-1">Change your profile picture</p>
                            </a>

                            <a href="{{ route('profile.business-info') }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Business Information</h5>
                                    <small><i class="fas fa-chevron-right"></i></small>
                                </div>
                                <p class="mb-1">Update your shop address and service area coverage</p>
                            </a>

                            <a href="{{ route('reviews.index') }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Reviews</h5>
                                    <small><i class="fas fa-chevron-right"></i></small>
                                </div>
                                <p class="mb-1">View customer reviews for your services</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
