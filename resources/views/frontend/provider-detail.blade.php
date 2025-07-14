@extends('frontend.layout.app')

@section('title', 'Service Providers')

@section('content')
    <section class="inner-page-main">

        <!-- Hero Search Section -->
        <section class="inner-page-sec1">
            <div class="container">
                <div class="hero-search-content">
                    <div class="main-heading text-center">
                        <h1 class="hero-title">Find Your Perfect <span class="highlight">Service Provider</span></h1>
                        <p class="hero-subtitle">Connect with trusted professionals in your area</p>
                    </div>
                    <form action="{{ route('service-providers.search') }}" method="GET" class="search-form">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="query" class="search-input"
                                placeholder="Enter provider name or service..." value="{{ request('query') }}">
                            <button class="search-btn" type="submit">
                                <span>Search</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Provider Details Section -->
        <section class="provider-details-section">
            <div class="container">
                <div class="provider-card">
                    <div class="row align-items-start">
                        <div class="col-lg-4 col-md-6">
                            <div class="provider-info">
                                <div class="provider-avatar">
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="status-badge">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Verified</span>
                                    </div>
                                </div>

                                <div class="provider-details">
                                    <h3 class="provider-name">
                                        {{ $provider->profile ? $provider->profile->display_name : $provider->name }}
                                    </h3>

                                    <div class="provider-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $provider->profile->service_area ?? 'Service area not specified' }}</span>
                                        </div>

                                        <div class="rating-section">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="text-white">4.9 (127 reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-6">
                            <div class="services-section">
                                <h4 class="section-title">Services Offered</h4>
                                <div class="services-grid">
                                    @foreach ($provider->services as $service)
                                        @if ($service->pivot->display_on_profile)
                                            <div class="service-badge">
                                                <i class="fas fa-tools"></i>
                                                <span>{{ $service->name }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="package-section">
                                    @foreach ($provider->packages as $package)
                                        <p class="card-text">{{ $package->description ?? 'No description' }}</p>
                                        <h5>{{ $package->name }}</h5>
                                        <ul>
                                            @foreach ($package->items as $item)
                                                <li>{{ $item->features }}</li>
                                            @endforeach
                                        </ul>

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
                                    @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Section -->
                <div class="calendar-section">
                    <h4 class="section-title">Available Dates</h4>
                    <div class="calendar-wrapper">
                        <div id="calendar"></div>
                    </div>
                </div>

                <div id="calendar" class="mb-4"></div>
            </div>
        </section>
    </section>

    <!-- Enhanced Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('booking.store') }}">
                @csrf
                <input type="hidden" name="package_id" id="selected_package_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title-wrapper">
                            <h5 class="modal-title" id="bookingModalLabel">
                                <i class="fas fa-calendar-check"></i>
                                Book Your Appointment
                            </h5>
                            <p class="modal-subtitle">Fill in your details to schedule a service</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="booking-form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>
                                    Full Name
                                </label>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="Enter your full name">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Email Address
                                </label>
                                <input type="email" name="email" class="form-control" required
                                    placeholder="Enter your email">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Preferred Date
                                </label>
                                <input type="date" name="booking_date" class="form-control" required
                                    id="booking_date">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Card Details:</label>
                            <div id="card-element" class="form-control"></div>
                            <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i>
                            Confirm Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #dc2626;
            --primary-dark: #b91c1c;
            --secondary-color: #1f2937;
            --accent-color: #ef4444;
            --success-color: #dc2626;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #111827;
            --card-bg: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --border-color: #374151;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.4);
        }

        .hero-search-section {
            background: linear-gradient(135deg, #000000, #1f2937, #dc2626);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-search-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(220,38,38,0.1)"/></svg>') repeat;
            background-size: 50px 50px;
        }

        .hero-search-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }

        .highlight {
            background: linear-gradient(45deg, var(--accent-color), #fca5a5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .search-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 8px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        .search-input-wrapper:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
            border-color: var(--primary-color);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            color: var(--text-secondary);
            z-index: 3;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 15px 50px;
            font-size: 16px;
            border-radius: 50px;
            background: transparent;
            color: var(--text-primary);
        }

        .search-input::placeholder {
            color: var(--text-secondary);
        }

        .search-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }

        .provider-details-section {
            padding: 80px 0;
            background: var(--light-bg);
        }

        .provider-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .provider-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .provider-info {
            text-align: center;
        }

        .provider-avatar {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: 3px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            margin: 0 auto;
        }

        .status-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            border: 2px solid var(--light-bg);
        }

        .provider-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 15px;
        }

        .provider-meta {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--text-secondary);
        }

        .rating-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .stars {
            color: var(--primary-color);
            display: flex;
            gap: 2px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .services-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .service-badge {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .service-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .booking-section {
            text-align: center;
        }

        .book-now-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .book-now-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }

        .calendar-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .calendar-wrapper {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .booking-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-lg);
            background: var(--card-bg);
        }

        .booking-modal .modal-body {
            background: var(--card-bg);
            color: var(--text-primary);
            padding: 30px;
        }

        .booking-modal .modal-header {
            background: linear-gradient(45deg, #000000, var(--secondary-color), var(--primary-color));
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 30px;
        }

        .modal-title-wrapper {
            flex: 1;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-subtitle {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .booking-form-grid {
            display: grid;
            gap: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            font-size: 16px;
            background: var(--light-bg);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .modal-footer {
            padding: 30px;
            border-top: 1px solid var(--border-color);
            background: var(--card-bg);
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-secondary {
            background: var(--light-bg);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--primary-color);
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            opacity: 1;
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        /* FullCalendar Styling */
        .fc {
            font-family: inherit;
        }

        .fc-header-toolbar {
            margin-bottom: 20px;
        }

        .fc-button-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 8px;
        }

        .fc-button-primary:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
        }

        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background: var(--primary-dark);
        }

        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid var(--border-color);
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border: 1px solid var(--border-color);
        }

        .fc-col-header-cell {
            background: var(--card-bg);
            color: var(--text-primary);
        }

        .fc-daygrid-day {
            background: var(--card-bg);
        }

        .fc-day-today {
            background: rgba(220, 38, 38, 0.1) !important;
        }

        .fc-daygrid-event {
            border-radius: 6px;
            border: none;
            font-weight: 500;
        }

        .fc-event-title {
            font-size: 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .provider-card {
                padding: 20px;
            }

            .provider-info {
                margin-bottom: 30px;
            }

            .services-grid {
                justify-content: center;
            }

            .calendar-section {
                padding: 20px;
            }
        }
    </style>

    <style>
        :root {
            --primary-color: #dc2626;
            --primary-dark: #b91c1c;
            --secondary-color: #1f2937;
            --accent-color: #ef4444;
            --success-color: #dc2626;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #111827;
            --card-bg: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --border-color: #374151;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.4);
        }

        .hero-search-section {
            background: linear-gradient(135deg, #000000, #1f2937, #dc2626);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-search-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(220,38,38,0.1)"/></svg>') repeat;
            background-size: 50px 50px;
        }

        .hero-search-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }

        .highlight {
            background: linear-gradient(45deg, var(--accent-color), #fca5a5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .search-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 8px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        .search-input-wrapper:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
            border-color: var(--primary-color);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            color: var(--text-secondary);
            z-index: 3;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 15px 50px;
            font-size: 16px;
            border-radius: 50px;
            background: transparent;
            color: var(--text-primary);
        }

        .search-input::placeholder {
            color: var(--text-secondary);
        }

        .search-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }

        .provider-details-section {
            padding: 80px 0;
            background: var(--light-bg);
        }

        .provider-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .provider-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .provider-info {
            text-align: center;
        }

        .provider-avatar {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: 3px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            margin: 0 auto;
        }

        .status-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            border: 2px solid var(--light-bg);
        }

        .provider-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 15px;
        }

        .provider-meta {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--text-secondary);
        }

        .rating-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .stars {
            color: var(--primary-color);
            display: flex;
            gap: 2px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .services-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .service-badge {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .service-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .booking-section {
            text-align: center;
        }

        .book-now-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .book-now-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }

        .calendar-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .calendar-wrapper {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .booking-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-lg);
            background: var(--card-bg);
        }

        .booking-modal .modal-body {
            background: var(--card-bg);
            color: var(--text-primary);
            padding: 30px;
        }

        .booking-modal .modal-header {
            background: linear-gradient(45deg, #000000, var(--secondary-color), var(--primary-color));
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 30px;
        }

        .modal-title-wrapper {
            flex: 1;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-subtitle {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .booking-form-grid {
            display: grid;
            gap: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            font-size: 16px;
            background: var(--light-bg);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .modal-footer {
            padding: 30px;
            border-top: 1px solid var(--border-color);
            background: var(--card-bg);
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-secondary {
            background: var(--light-bg);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--primary-color);
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.2);
            opacity: 1;
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        /* FullCalendar Styling */
        .fc {
            font-family: inherit;
        }

        .fc-header-toolbar {
            margin-bottom: 20px;
        }

        .fc-button-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 8px;
        }

        .fc-button-primary:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
        }

        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background: var(--primary-dark);
        }

        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid var(--border-color);
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border: 1px solid var(--border-color);
        }

        .fc-col-header-cell {
            background: var(--card-bg);
            color: var(--text-primary);
        }

        .fc-daygrid-day {
            background: var(--card-bg);
        }

        .fc-day-today {
            background: rgba(220, 38, 38, 0.1) !important;
        }

        .fc-daygrid-event {
            border-radius: 6px;
            border: none;
            font-weight: 500;
        }

        .fc-event-title {
            font-size: 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .provider-card {
                padding: 20px;
            }

            .provider-info {
                margin-bottom: 30px;
            }

            .services-grid {
                justify-content: center;
            }

            .calendar-section {
                padding: 20px;
            }
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById("booking_date").setAttribute("min", today);

            // Get booked dates from server
            var bookedDates = @json($bookings->pluck('booking_date'));

            // Initialize calendar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',

                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: generateEvents(bookedDates),
                eventClick: function(info) {
                    if (info.event.extendedProps.available) {
                        // Set the date in the booking form
                        document.getElementById('booking_date').value = info.event.startStr;
                        // Open the booking modal
                        var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
                        modal.show();
                    }
                },
                eventMouseEnter: function(info) {
                    info.el.style.cursor = info.event.extendedProps.available ? 'pointer' : 'default';
                }
            });

            // Render calendar with slight delay to ensure proper initialization
            setTimeout(() => {
                calendar.render();
            }, 100);
        });

        function generateEvents(bookedDates) {
            const events = [];
            const startDate = new Date();
            const endDate = new Date();
            endDate.setMonth(endDate.getMonth() + 2); // Show 2 months ahead

            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                const formatted = d.toISOString().split('T')[0];

                // Skip past dates
                if (d < new Date().setHours(0, 0, 0, 0)) {
                    continue;
                }

                if (bookedDates.includes(formatted)) {
                    events.push({
                        title: '❌ Booked',
                        start: formatted,
                        color: '#ef4444',
                        textColor: 'white',
                        available: false
                    });
                } else {
                    events.push({
                        title: '✅ Available',
                        start: formatted,
                        color: '#dc2626',
                        textColor: 'white',
                        available: true
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
