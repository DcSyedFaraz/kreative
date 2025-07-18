@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-3">Service Provider Conditions</h4>
    <form method="POST" action="{{ route('provider.conditions.update') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Conditions</label>
            <textarea name="conditions" class="form-control" rows="4">{{ old('conditions', $condition->conditions ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Base Price</label>
            <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $condition->base_price ?? '') }}" class="form-control">
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
