@extends('frontend.layout.app')

@section('title', 'Service Providers')

@section('content')
    <section class="inner-page-main">

        <!-- Search Section -->
        <section class="inner-page-sec1">
            <div class="container">
                <div class="main-heading">
                    <h2>Search <span class="highlight">Service Providers</span></h2>
                </div>
                <form action="{{ route('service-providers.search') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="query" class="form-control" placeholder="Enter provider name"
                            value="{{ request('query') }}">
                        <button class="btn login" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Results Section -->
        <section class="sec3">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-4">

                        <h5> Display Name:
                            {{ $provider->profile ? $provider->profile->display_name : $provider->name }}
                        </h5>
                        <h6 class="mt-3"> Service Area:
                            {{ $provider->profile->service_area ?? '' }}
                        </h6>
                        <div>
                            @foreach ($provider->services as $service)
                                @if ($service->pivot->display_on_profile)
                                    <span>Service Name: {{ $service->name }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($user->packages as $package)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 d-flex flex-column">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="card-title mb-0">{{ ucfirst($package->name) }}</h4>
                                        <h5 class="mb-0"><strong>PKR:</strong> {{ $package->price }}</h5>
                                    </div>

                                    <p class="card-text">{{ $package->description ?? 'No description' }}</p>
                                    <ul>
                                        @foreach ($package->items as $item)
                                            <li>{{ $item->features }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @auth
                                    @if (auth()->user()->id === $package->user_id)
                                        <div class="d-flex justify-content-center mb-4">
                                            <button class="btn btn-success select-package" data-bs-toggle="modal"
                                                data-bs-target="#bookingModal" data-package-id="{{ $package->id }}"
                                                data-package-price="{{ $package->price }}"
                                                data-package-name="{{ $package->name }}">
                                                Select
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center mb-4">
                                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                        </div>
                                    @endif
                                @endauth
                                @guest
                                    <div class="d-flex justify-content-center mb-4">
                                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="calendar" class="mb-4"></div>
            </div>
        </section>
    </section>

    <!-- Booking Form Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('booking.store') }}" id="payment-form">
                @csrf
                <input type="hidden" name="package_id" id="selected_package_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingModalLabel">Booking Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Booking Date:</label>
                            <input type="date" name="booking_date" class="form-control" required id="booking_date">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Card Details:</label>
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Booking</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById("booking_date").setAttribute("min", today);

            var bookedDates = @json($bookings->pluck('booking_date'));

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',

                events: generateEvents(bookedDates),

            });

            setTimeout(() => {
                calendar.render();
            }, 100);
        });

        function generateEvents(bookedDates) {
            const events = [];
            const startDate = new Date();
            const endDate = new Date();
            endDate.setMonth(endDate.getMonth() + 1);

            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                const formatted = d.toISOString().split('T')[0];

                if (bookedDates.includes(formatted)) {
                    events.push({
                        title: 'Booked',
                        start: formatted,
                        color: 'red'
                    });
                } else {
                    events.push({
                        title: 'Available',
                        start: formatted,
                        color: 'green'
                    });
                }
            }

            return events;
        }
    </script>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const packageId = document.getElementById('selected_package_id').value;
            console.log("Package ID:", packageId);

            // Step 1: Create PaymentIntent from backend
            const response = await fetch("{{ route('payment.intent') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    package_id: packageId
                })
            });

            if (!response.ok) {
                const text = await response.text();
                document.getElementById('card-errors').textContent = "Payment error: " + text;
                return;
            }

            const data = await response.json();

            if (data.error) {
                document.getElementById('card-errors').textContent = data.error;
                return;
            }

            const clientSecret = data.clientSecret;
            const paymentIntentId = data.paymentIntentId;

            // Step 2: Confirm the card payment
            const result = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: form.querySelector('input[name="name"]').value,
                        email: form.querySelector('input[name="email"]').value
                    }
                }
            });

            if (result.error) {
                document.getElementById('card-errors').textContent = result.error.message;
            } else {
                if (result.paymentIntent.status === 'succeeded') {
                    // Step 3: Add payment_intent_id to form and submit
                    const input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', 'payment_intent_id');
                    input.setAttribute('value', paymentIntentId);
                    form.appendChild(input);

                    form.submit();
                }
            }
        });

        // Set selected package ID
        document.querySelectorAll('.select-package').forEach(button => {
            button.addEventListener('click', function() {
                const packageId = this.dataset.packageId;
                document.getElementById('selected_package_id').value = packageId;
            });
        });
    </script>
@endsection
