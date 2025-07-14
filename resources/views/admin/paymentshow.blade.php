@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <h2>User Payment Details</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $payment->id }}</p>
                <p><strong>User Name:</strong> {{ $payment->user->username ?? 'N/A' }}</p>
                <p><strong>User Email:</strong> {{ $payment->user->email ?? 'N/A' }}</p>
                <p><strong>Package Name:</strong> {{ $payment->package->name ?? 'N/A' }}</p>
                <p><strong>Package Description:</strong> {{ $payment->package->description ?? 'N/A' }}</p>
                <p><strong>Package Items:</strong> {{ $payment->package->items->pluck('features')->join(', ') ?? 'N/A' }}</p>
                <p><strong>Package Price:</strong> {{ $payment->package->price ?? 'N/A' }}</p>
                <p><strong>Amount:</strong> {{ $payment->amount ?? 'N/A' }}</p>
                <p><strong>Booking Date:</strong> {{ $payment->booking->booking_date }}</p>
                <p><strong>Payment Status:</strong>
                    @if ($payment->payment_status == 'success')
                        <span class="badge bg-success">success</span>
                    @else
                        <span class="badge bg-info">pending</span>
                    @endif
                </p>
            </div>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
