@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Business Information</span>
                        <a href="{{ route('profile.index') }}" class="btn btn-sm btn-secondary">Back to Profile</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('profile.update-business-info') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="shop_address" class="form-label">Shop Address</label>
                                <input type="text" class="form-control @error('shop_address') is-invalid @enderror"
                                    id="shop_address" name="shop_address"
                                    value="{{ $profile->shop_address ?? old('shop_address') }}">
                                @error('shop_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="service_area" class="form-label">Service Area Coverage</label>
                                <textarea class="form-control @error('service_area') is-invalid @enderror" id="service_area" name="service_area"
                                    rows="4">{{ $profile->service_area ?? old('service_area') }}</textarea>
                                @error('service_area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">List the areas/regions where you provide your services</div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
