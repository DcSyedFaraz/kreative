@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-3">Create Custom Package for {{ $provider->name }}</h4>
    <form method="POST" action="{{ route('custom-packages.store', $provider) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Features (comma separated)</label>
            <input type="text" name="features[]" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $condition->base_price ?? '' }}" required>
        </div>
        <button class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
