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
                        <p class="mt-3"> Service Area:
                            {{ $provider->profile->service_area ?? '' }}
                        </p>
                        <div>
                            @foreach ($provider->services as $service)
                                @if ($service->pivot->display_on_profile)
                                    <span>Service Name: {{ $service->name }}</span>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal"
                                data-bs-target="#bookingModal">
                                Book Now
                            </button>
                        </div>
                    </div>
                    <div id="calendar" class="mt-5"></div>
                </div>
            </div>
        </section>
    </section>

    <!-- Booking Form Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('booking.store') }}">
                @csrf
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
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Booking</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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


@endsection
