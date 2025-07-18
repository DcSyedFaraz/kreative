@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-3">Edit Custom Package</h4>
    <form method="POST" action="{{ route('custom-packages.update', $customPackage) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $customPackage->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $customPackage->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Features (comma separated)</label>
            <input type="text" name="features[]" class="form-control" value="{{ implode(',', $customPackage->features ?? []) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $customPackage->price) }}" required>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
