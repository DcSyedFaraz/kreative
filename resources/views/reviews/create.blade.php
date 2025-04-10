@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Leave a Review for {{ $user->name }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('reviews.store', $user->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="rating-selection">
                                    <div class="btn-group" role="group">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <input type="radio" class="btn-check" name="rating"
                                                id="rating{{ $i }}" value="{{ $i }}"
                                                {{ $i == 5 ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning"
                                                for="rating{{ $i }}">{{ $i }}</label>
                                        @endfor
                                    </div>
                                </div>
                                @error('rating')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Your Review</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
