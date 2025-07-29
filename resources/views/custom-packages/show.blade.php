@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-3">{{ $customPackage->name }}</h4>
        <p>{{ $customPackage->description }}</p>

        <ul>
            @foreach ($customPackage->features ?? [] as $feature)
                <li>{{ $feature }}</li>
            @endforeach
        </ul>

        @if ($customPackage->options)
            <h6>Selected Options</h6>
            <ul>
                @foreach ($customPackage->options as $opt)
                    <li>{{ $opt['name'] }} x {{ $opt['quantity'] }} ({{ $opt['unit_price'] }})</li>
                @endforeach
            </ul>
        @endif

        <p><strong>Booking Date:</strong> {{ optional($customPackage->booking_date)->format('Y-m-d') ?? 'N/A' }}</p>
        <p><strong>Total:</strong> ${{ number_format($customPackage->price / 100, 2) }}</p>

        @if ($customPackage->payment_status === 'pending')
            <!-- STEP 1: your Stripe Elements form -->
            <form id="payment-form" method="POST" action="{{ route('custom-packages.pay', $customPackage) }}">
                @csrf
                <input type="hidden" name="package_id" id="selected_package_id" value="{{ $customPackage->id }}">

                <div class="mb-3">
                    <label for="booking_date">Booking Date</label>
                    <input id="booking_date" name="booking_date" type="date" class="form-control"
                        value="{{ old('booking_date', optional($customPackage->booking_date)->format('Y-m-d')) }}">
                    @if (!$isDateAvailable)
                        <small class="text-danger">Selected date is no longer available, please choose another.</small>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Card details</label>
                    <div id="card-element" class="form-control"></div>
                    <div id="card-errors" role="alert" class="text-danger mt-2" style="display:none;"></div>
                </div>

                <button id="submit-button" class="btn btn-success">
                    Pay ${{ number_format($customPackage->price / 100, 2) }}
                </button>
            </form>
        @else
            <p class="text-success">Payment Completed</p>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const card = elements.create('card', {
            hidePostalCode: true
        });
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const button = document.getElementById('submit-button');
        const errors = document.getElementById('card-errors');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            button.disabled = true;
            button.textContent = 'Processing…';

            try {
                // 1) Create a PaymentIntent
                const resp = await fetch("{{ route('payment.custom.intent') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        package_id: {{ $customPackage->id }}
                    })
                });

                if (!resp.ok) {
                    const msg = await resp.text();
                    throw new Error(msg || 'Could not create payment intent');
                }

                const {
                    clientSecret,
                    paymentIntentId
                } = await resp.json();

                // 2) Confirm the card payment
                const {
                    error,
                    paymentIntent
                } = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card,
                        billing_details: {
                            name: form.querySelector('#name').value,
                            email: form.querySelector('#email').value,
                        }
                    }
                });

                if (error || paymentIntent.status !== 'succeeded') {
                    throw error || new Error('Payment failed');
                }

                // 3) Append intent ID & submit form
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'payment_intent_id';
                input.value = paymentIntentId;
                form.appendChild(input);
                form.submit();

            } catch (err) {
                errors.textContent = err.message;
                errors.style.display = 'block';
                button.disabled = false;
                button.textContent = 'Pay ${{ number_format($customPackage->price, 2) }}';
            }
        });


        card.addEventListener('change', ({
            error
        }) => {
            if (error) {
                errors.textContent = error.message;
                errors.style.display = 'block';
            } else {
                errors.textContent = '';
                errors.style.display = 'none';
            }
        });
    </script>
@endpush
