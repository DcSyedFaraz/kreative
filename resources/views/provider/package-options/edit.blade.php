@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-3">Custom Package Options</h4>
    <form method="POST" action="{{ route('package-options.update') }}">
        @csrf
        <div id="options-wrapper">
            @foreach($options as $index => $option)
                <div class="row mb-2 option-row">
                    <div class="col">
                        <input type="text" name="options[{{ $index }}][name]" class="form-control" value="{{ $option->name }}" placeholder="Option name">
                    </div>
                    <div class="col">
                        <input type="number" step="0.01" name="options[{{ $index }}][base_price]" class="form-control" value="{{ $option->base_price }}" placeholder="Base Price">
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-secondary" id="add-option">Add Option</button>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
<script>
document.getElementById('add-option').addEventListener('click', function(){
    let wrapper = document.getElementById('options-wrapper');
    let index = wrapper.querySelectorAll('.option-row').length;
    let div = document.createElement('div');
    div.className = 'row mb-2 option-row';
    div.innerHTML = `<div class="col"><input type="text" name="options[${index}][name]" class="form-control" placeholder="Option name"></div><div class="col"><input type="number" step="0.01" name="options[${index}][base_price]" class="form-control" placeholder="Base Price"></div>`;
    wrapper.appendChild(div);
});
</script>
@endsection
