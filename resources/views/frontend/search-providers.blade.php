@extends('frontend.layout.app')

@section('title', 'Service Providers')

@section('content')
    <section class="inner-page-main">

        <!-- Search Section -->
        <section class="inner-page-sec1">
            <div class="container">
                <div class="main-heading">
                    <h2>Search <span class="highlight">Service Providers</span></h2>
                </div>
                <form action="{{ route('service-providers.search') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="query" class="form-control" placeholder="Enter provider name"
                            value="{{ request('query') }}">
                        <button class="btn login" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Results Section -->
        <section class="sec3">
            <div class="container">
                @if ($providers->isEmpty())
                    <p class="my-5">No providers found.</p>
                @else
                    <div class="row mb-5">
                        @foreach ($providers as $provider)
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    @if ($provider->profile && $provider->profile->profile_picture)
                                        <img src="{{ asset('storage/profile-pictures/' . $provider->profile->profile_picture) }}"
                                            class="card-img-top" alt="{{ $provider->profile->display_name }}">
                                    @else
                                        <img src="{{ asset('assets/images/frontend/default-profile.png') }}"
                                            class="card-img-top" alt="{{ $provider->name }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            {{ $provider->profile ? $provider->profile->display_name : $provider->name }}
                                        </h5>
                                        <p class="card-text">
                                            {{ $provider->profile->service_area ?? '' }}
                                        </p>
                                        <div>
                                            @foreach ($provider->services as $service)
                                                @if ($service->pivot->display_on_profile)
                                                    <span
                                                        class="badge text-capitalize bg-primary">{{ $service->name }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="mt-3">
                                            <!-- Detail Button -->
                                            <a href="{{ route('provider.detail', $provider->id) }}" class="btn btn-primary">
                                                Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </section>
@endsection
