@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Reviews You've Received</span>
                        <a href="{{ route('customer-reviews.index') }}" class="btn btn-sm btn-secondary">Back to Customers</a>
                    </div>

                    <div class="card-body">
                        @if ($reviewsReceived->count() > 0)
                            @foreach ($reviewsReceived as $review)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title mb-0">From: {{ $review->provider->name }}</h5>
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="card-text">{{ $review->content }}</p>
                                        <p class="card-text"><small
                                                class="text-muted">{{ $review->created_at->diffForHumans() }}</small></p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info" role="alert">
                                You haven't received any customer reviews yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
