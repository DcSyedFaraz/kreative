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

        @if($options->count())
            <h5>Options</h5>
            @foreach($options as $option)
                @php
                    $selected = collect($customPackage->options)->firstWhere('option_id', $option->id);
                    $qty = $selected['quantity'] ?? 0;
                @endphp
                <div class="mb-3">
                    <label class="form-label">{{ $option->name }} (${{ number_format($option->base_price,2) }} each)</label>
                    <input type="number" min="0" name="options[{{ $option->id }}]" value="{{ $qty }}" class="form-control option-input" data-price="{{ $option->base_price }}">
                </div>
            @endforeach
        @endif

        <div class="mb-3">
            <label class="form-label">Total Price</label>
            <input type="number" step="0.01" name="price" id="total_price" class="form-control" value="{{ $customPackage->price }}" readonly>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
<script>
function updateTotal(){
    let total = 0;
    document.querySelectorAll('.option-input').forEach(el => {
        const qty = parseInt(el.value) || 0;
        const price = parseFloat(el.dataset.price);
        total += qty * price;
    });
    document.getElementById('total_price').value = total.toFixed(2);
}
document.querySelectorAll('.option-input').forEach(el => el.addEventListener('input', updateTotal));
updateTotal();
</script>
@endsection
