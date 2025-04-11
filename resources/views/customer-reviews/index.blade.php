@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Review Customers</span>
                        <a href="{{ route('profile.index') }}" class="btn btn-sm btn-secondary">Back to Profile</a>
                    </div>

                    <div class="card-body">
                        @if ($customers->count() > 0)
                            <div class="list-group">
                                @foreach ($customers as $customer)
                                    <a href="{{ route('customer-reviews.create', $customer->id) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $customer->fname }} {{ $customer->lname }}</h5>
                                            <small><i class="fas fa-chevron-right"></i></small>
                                        </div>
                                        <p class="mb-1">Leave a review for this customer</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                You don't have any customers to review yet.
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('reviews.index') }}" class="btn btn-outline-primary">
                                <i data-feather="eye"></i> View Reviews You've Received
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
