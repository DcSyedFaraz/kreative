@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h4 class="mb-3">{{ $customPackage->name }}</h4>
    <p>{{ $customPackage->description }}</p>
    <ul>
        @foreach($customPackage->features ?? [] as $feature)
            <li>{{ $feature }}</li>
        @endforeach
    </ul>
    @if($customPackage->options)
        <h6>Selected Options</h6>
        <ul>
            @foreach($customPackage->options as $opt)
                <li>{{ $opt['name'] }} x {{ $opt['quantity'] }} ({{ $opt['unit_price'] }})</li>
            @endforeach
        </ul>
    @endif
    <p>Price: {{ $customPackage->price }}</p>
    @if($customPackage->payment_status === 'pending')
        <form method="POST" action="{{ route('custom-packages.pay', $customPackage) }}">
            @csrf
            <button class="btn btn-success">Pay with Stripe</button>
        </form>
    @else
        <p class="text-success">Payment Completed</p>
    @endif
</div>
@endsection
