@extends('frontend.layout.app')

@section('title', 'Service Providers')

@section('content')
    <section class="inner-page-main">

        <!-- Enhanced Hero Search Section -->
        <section class="inner-page-sec1 hero-section">
            <div class="hero-bg-animation"></div>
            <div class="hero-particles"></div>
            <div class="container">
                <div class="hero-search-content">
                    <div class="main-heading text-center">
                        <h1 class="hero-title animate-fade-in">
                            Find Your Perfect
                            <span class="highlight-text">Service Provider</span>
                        </h1>
                        <p class="hero-subtitle animate-fade-in-delay">Connect with trusted professionals in your area</p>
                    </div>
                    <form action="{{ route('service-providers.search') }}" method="GET"
                        class="search-form animate-scale-in">
                        <div class="search-input-wrapper">
                            <div class="search-glow"></div>
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="query" class="search-input"
                                placeholder="Enter provider name or service..." value="{{ request('query') }}">
                            <button class="search-btn" type="submit">
                                <span>Search</span>
                                <i class="fas fa-arrow-right"></i>
                                <div class="btn-ripple"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Enhanced Provider Details Section -->
        <section class="provider-details-section">
            <div class="container">
                <div class="provider-card glass-card">
                    <div class="card-glow"></div>
                    <div class="row align-items-start">
                        <div class="col-lg-4 col-md-6">
                            <div class="provider-info">
                                <div class="provider-avatar">
                                    <div class="avatar-container">
                                        <div class="avatar-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="avatar-ring"></div>
                                        <div class="avatar-pulse"></div>
                                    </div>
                                    <div class="status-badge verified-badge">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Verified</span>
                                        <div class="badge-shine"></div>
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
                                            @php
                                                $totalReviews = $provider->customerReviewsGiven->count();
                                                $averageRating =
                                                    $totalReviews > 0
                                                        ? number_format(
                                                            $provider->customerReviewsGiven->avg('rating'),
                                                            1,
                                                        )
                                                        : 0;
                                            @endphp

                                            @if ($totalReviews > 0)
                                                <div class="rating-container">
                                                    <div class="stars-wrapper">
                                                        @for ($i = 0; $i < floor($averageRating); $i++)
                                                            <i class="fas fa-star star-filled"></i>
                                                        @endfor

                                                        @if ($averageRating - floor($averageRating) >= 0.5)
                                                            <i class="fas fa-star-half-alt star-half"></i>
                                                        @endif

                                                        @for ($i = 0; $i < 5 - ceil($averageRating); $i++)
                                                            <i class="far fa-star star-empty"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="rating-text">{{ $averageRating }} ({{ $totalReviews }}
                                                        reviews)</span>
                                                </div>
                                            @else
                                                <div class="no-reviews">
                                                    <i class="fas fa-star-o"></i>
                                                    <span>No reviews yet</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-6">
                            <div class="services-section">
                                <h4 class="section-title">
                                    <span class="title-icon">
                                        <i class="fas fa-tools"></i>
                                    </span>
                                    Services Offered
                                </h4>
                                <div class="services-grid">
                                    @foreach ($provider->services as $service)
                                        @if ($service->pivot->display_on_profile)
                                            <div class="service-badge modern-badge">
                                                <i class="fas fa-cog"></i>
                                                <span>{{ $service->name }}</span>
                                                <div class="badge-glow"></div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Enhanced Package Display -->
                                <div class="packages-container">
                                    @foreach ($provider->packages as $package)
                                        <div class="package-card">
                                            <div class="package-header">
                                                <h5 class="package-name">{{ $package->name }}</h5>
                                                <div class="package-price">${{ $package->price }}</div>
                                            </div>
                                            <p class="package-description">{{ $package->description ?? 'No description' }}
                                            </p>

                                            <div class="package-features">
                                                <h6>Features:</h6>
                                                <ul class="features-list">
                                                    @foreach ($package->items as $item)
                                                        <li>
                                                            <i class="fas fa-check"></i>
                                                            {{ $item->features }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="package-actions">
                                                @auth
                                                    @if (auth()->user()->id === $package->user_id)
                                                        <button class="btn btn-primary select-package-btn"
                                                            data-bs-toggle="modal" data-bs-target="#bookingModal"
                                                            data-package-id="{{ $package->id }}"
                                                            data-package-price="{{ $package->price }}"
                                                            data-package-name="{{ $package->name }}">
                                                            <i class="fas fa-calendar-plus"></i>
                                                            <span>Select Package</span>
                                                            <div class="btn-shimmer"></div>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                                            <i class="fas fa-sign-in-alt"></i>
                                                            Login to Book
                                                        </a>
                                                    @endif
                                                @endauth
                                                @guest
                                                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-sign-in-alt"></i>
                                                        Login to Book
                                                    </a>
                                                @endguest
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-end my-3">
                                    @auth
                                        <a href="{{ route('custom-packages.create', $provider) }}" class="btn btn-warning">
                                            Request Custom Package
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-warning">Login to Request Custom Package</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Calendar Section -->
                <div class="calendar-section glass-card">
                    <div class="calendar-header">
                        <h4 class="section-title">
                            <span class="title-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            Available Dates
                        </h4>
                        <div class="calendar-legend">
                            <div class="legend-item">
                                <div class="legend-dot available"></div>
                                <span>Available</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot booked"></div>
                                <span>Booked</span>
                            </div>
                        </div>
                    </div>
                    <div class="calendar-wrapper">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <!-- Package Selection Modal -->
    <div class="modal fade package-selection-modal" id="packageSelectionModal" tabindex="-1"
        aria-labelledby="packageSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content glass-modal">
                <div class="modal-header">
                    <div class="modal-title-wrapper">
                        <h5 class="modal-title" id="packageSelectionModalLabel">
                            <i class="fas fa-box"></i>
                            Select a Package
                        </h5>
                        <p class="modal-subtitle">Choose the service package for your booking</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="packages-selection-grid">
                        @foreach ($provider->packages as $package)
                            <div class="package-selection-card" data-package-id="{{ $package->id }}"
                                data-package-name="{{ $package->name }}" data-package-price="{{ $package->price }}">
                                <div class="package-selection-header">
                                    <h6 class="package-selection-name">{{ $package->name }}</h6>
                                    <div class="package-selection-price">${{ number_format($package->price, 2) }}</div>
                                </div>

                                <p class="package-selection-description">
                                    {{ $package->description ?? 'No description available' }}</p>

                                <div class="package-selection-features">
                                    <ul class="features-selection-list">
                                        @foreach ($package->items as $item)
                                            <li>
                                                <i class="fas fa-check"></i>
                                                {{ $item->features }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="package-selection-actions">
                                    <button type="button" class="btn btn-outline-primary select-this-package">
                                        <i class="fas fa-check-circle"></i>
                                        Select This Package
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Booking Modal -->
    <div class="modal fade booking-modal" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('booking.store') }}" id="payment-form">
                @csrf
                <input type="hidden" name="package_id" id="selected_package_id">

                <div class="modal-content glass-modal">
                    <div class="modal-header">
                        <div class="modal-title-wrapper">
                            <h5 class="modal-title" id="bookingModalLabel">
                                <i class="fas fa-calendar-check"></i>
                                Book Your Appointment
                            </h5>
                            <p class="modal-subtitle">Fill in your details to schedule a service</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Selected Package Summary -->
                        <div class="selected-package-summary" id="selectedPackageSummary" style="display: none;">
                            <div class="summary-header">
                                <h6><i class="fas fa-box"></i> Selected Package</h6>
                                <button type="button" class="btn-change-package" onclick="changePackage()">
                                    <i class="fas fa-edit"></i>
                                    Change
                                </button>
                            </div>
                            <div class="summary-content">
                                <div class="summary-name" id="summaryPackageName"></div>
                                <div class="summary-price" id="summaryPackagePrice"></div>
                            </div>
                        </div>

                        <div class="booking-form-grid">
                            <div class="form-group floating-label">
                                <input type="text" name="name" class="form-control" required id="name">
                                <label for="name">
                                    <i class="fas fa-user"></i>
                                    Full Name
                                </label>
                            </div>

                            <div class="form-group floating-label">
                                <input type="email" name="email" class="form-control" required id="email">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email Address
                                </label>
                            </div>

                            <div class="form-group floating-label">
                                <input type="date" name="booking_date" class="form-control" required
                                    id="booking_date">
                                <label for="booking_date">
                                    <i class="fas fa-calendar-alt"></i>
                                    Preferred Date
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-credit-card"></i>
                                    Payment Details
                                </label>
                                <div class="card-input-wrapper">
                                    <div id="card-element" class="form-control"></div>
                                </div>
                                <div id="card-errors" class="error-message" role="alert"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i>
                            <span>Confirm Booking</span>
                            <span class="booking-total" id="bookingTotal"></span>
                            <div class="btn-loader">
                                <div class="spinner"></div>
                            </div>
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
            --primary-light: #f87171;
            --secondary-color: #1f2937;
            --accent-color: #ef4444;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-bg: #0f172a;
            --light-bg: #111827;
            --card-bg: #1f2937;
            --card-hover: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --text-muted: #9ca3af;
            --border-color: #374151;
            --border-light: #4b5563;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            --shadow-xl: 0 35px 60px -12px rgba(0, 0, 0, 0.8);
            --glow: 0 0 20px rgba(220, 38, 38, 0.3);
            --glow-intense: 0 0 40px rgba(220, 38, 38, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: var(--glow);
            }

            50% {
                box-shadow: var(--glow-intense);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-fade-in-delay {
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out 0.4s both;
        }

        /* Enhanced Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #000000, #1f2937, #dc2626);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }

        .hero-bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(220, 38, 38, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(220, 38, 38, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(220, 38, 38, 0.05) 0%, transparent 50%);
            animation: pulse 4s ease-in-out infinite;
        }

        .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(2px 2px at 20px 30px, rgba(220, 38, 38, 0.3), transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(220, 38, 38, 0.2), transparent),
                radial-gradient(1px 1px at 90px 40px, rgba(220, 38, 38, 0.3), transparent);
            background-repeat: repeat;
            background-size: 100px 100px;
            animation: shimmer 20s linear infinite;
        }

        .hero-search-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .highlight-text {
            background: linear-gradient(45deg, var(--accent-color), #fca5a5, var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            animation: glow 2s ease-in-out infinite;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            font-weight: 400;
        }

        /* Enhanced Search Form */
        .search-form {
            max-width: 700px;
            margin: 0 auto;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 60px;
            padding: 12px;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s ease;
        }

        .search-input-wrapper:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-xl), var(--glow);
        }

        .search-glow {
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 60px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .search-input-wrapper:focus-within .search-glow {
            opacity: 1;
        }

        .search-icon {
            position: absolute;
            left: 25px;
            color: var(--text-secondary);
            font-size: 18px;
            z-index: 3;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 18px 60px;
            font-size: 18px;
            border-radius: 60px;
            background: transparent;
            color: var(--text-primary);
            font-weight: 500;
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 18px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(220, 38, 38, 0.5);
        }

        .btn-ripple {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s ease, height 0.3s ease;
        }

        .search-btn:active .btn-ripple {
            width: 100px;
            height: 100px;
        }

        /* Enhanced Provider Details */
        .provider-details-section {
            padding: 100px 0;
            background: var(--light-bg);
        }

        .glass-card {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 50px;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .card-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .glass-card:hover .card-glow {
            opacity: 1;
        }

        /* Enhanced Provider Info */
        .provider-info {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .provider-avatar {
            position: relative;
            display: inline-block;
            margin-bottom: 30px;
        }

        .avatar-container {
            position: relative;
            display: inline-block;
        }

        .avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: 4px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 56px;
            color: white;
            position: relative;
            z-index: 2;
            box-shadow: var(--shadow-lg);
        }

        .avatar-ring {
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            border: 2px solid var(--primary-color);
            border-radius: 50%;
            opacity: 0.5;
            z-index: 1;
        }

        .avatar-pulse {
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            border: 1px solid var(--primary-color);
            border-radius: 50%;
            animation: pulse 2s infinite;
            z-index: 0;
        }

        .verified-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: linear-gradient(45deg, var(--success-color), #34d399);
            color: white;
            padding: 8px 12px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            border: 3px solid var(--light-bg);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .badge-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        .provider-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .provider-meta {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--text-secondary);
            font-size: 16px;
        }

        /* Enhanced Rating Section */
        .rating-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 15px;
            background: rgba(220, 38, 38, 0.1);
            border-radius: 15px;
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .stars-wrapper {
            display: flex;
            gap: 3px;
        }

        .star-filled {
            color: var(--primary-color);
            filter: drop-shadow(0 0 3px rgba(220, 38, 38, 0.5));
        }

        .star-half {
            color: var(--primary-color);
            filter: drop-shadow(0 0 3px rgba(220, 38, 38, 0.5));
        }

        .star-empty {
            color: var(--text-muted);
        }

        .rating-text {
            color: var(--text-primary);
            font-weight: 600;
        }

        .no-reviews {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-style: italic;
        }

        /* Enhanced Section Titles */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .title-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: var(--shadow);
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            margin-left: 15px;
        }

        /* Enhanced Services Grid */
        .services-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 40px;
        }

        .modern-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .modern-badge:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .badge-glow {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s infinite;
        }

        /* Enhanced Package Cards */
        .packages-container {
            display: grid;
            gap: 25px;
            margin-top: 30px;
        }

        .package-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .package-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .package-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .package-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .package-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .package-description {
            color: var(--text-secondary);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .package-features h6 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            color: var(--text-secondary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .features-list i {
            color: var(--success-color);
            font-size: 12px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .package-actions {
            display: flex;
            justify-content: center;
        }

        /* Enhanced Buttons */
        .btn {
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--card-bg);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--card-hover);
            color: var(--text-primary);
            border-color: var(--primary-color);
        }

        .btn-shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s infinite;
        }

        .select-package-btn:hover .btn-shimmer {
            animation: shimmer 0.5s ease-in-out;
        }

        /* Enhanced Calendar Section */
        .calendar-section {
            margin-top: 50px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .calendar-legend {
            display: flex;
            gap: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .legend-dot.available {
            background: var(--success-color);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
        }

        .legend-dot.booked {
            background: var(--danger-color);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.3);
        }

        .calendar-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced Modal */
        .booking-modal .modal-dialog {
            max-width: 600px;
            margin: 2rem auto;
        }

        .glass-modal {
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #000000, var(--secondary-color), var(--primary-color));
            color: white;
            padding: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title-wrapper {
            flex: 1;
        }

        .modal-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-subtitle {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
            font-weight: 400;
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .modal-body {
            padding: 40px;
        }

        .booking-form-grid {
            display: grid;
            gap: 30px;
        }

        /* Enhanced Form Controls */
        .floating-label {
            position: relative;
            margin-bottom: 0;
        }

        .floating-label .form-control {
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 20px 15px 10px 50px;
            font-size: 16px;
            background: rgba(15, 23, 42, 0.6);
            color: var(--text-primary);
            transition: all 0.3s ease;
            height: auto;
        }

        .floating-label .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            background: rgba(15, 23, 42, 0.8);
        }

        .floating-label .form-control:focus+label,
        .floating-label .form-control:not(:placeholder-shown)+label {
            transform: translateY(-25px) scale(0.85);
            color: var(--primary-color);
        }

        .floating-label label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            padding: 0 5px;
        }

        .floating-label label i {
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-group {
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }

        .card-input-wrapper {
            position: relative;
        }

        .card-input-wrapper .form-control {
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 20px;
            font-size: 16px;
            background: rgba(15, 23, 42, 0.6);
            color: var(--text-primary);
            transition: all 0.3s ease;
            min-height: 50px;
        }

        .card-input-wrapper .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .card-icons {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            display: flex;
            gap: 10px;
            font-size: 20px;
            color: var(--text-muted);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .modal-footer {
            padding: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .btn-loader {
            display: none;
        }

        .btn.loading .btn-loader {
            display: block;
        }

        .btn.loading span {
            opacity: 0;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* FullCalendar Enhancements */
        .fc {
            font-family: 'Inter', sans-serif;
        }

        .fc-header-toolbar {
            margin-bottom: 25px;
            padding: 0 10px;
        }

        .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
        }

        .fc-button-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .fc-button-primary:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background: var(--primary-dark);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border: 1px solid #f3f4f6;
        }

        .fc-col-header-cell {
            background: #f8fafc;
            color: var(--secondary-color);
            font-weight: 600;
            padding: 15px 5px;
        }

        .fc-daygrid-day {
            background: white;
            transition: background-color 0.2s ease;
        }

        .fc-daygrid-day:hover {
            background: #f8fafc;
        }

        .fc-day-today {
            background: rgba(220, 38, 38, 0.05) !important;
        }

        .fc-daygrid-event {
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 12px;
            padding: 2px 6px;
            margin: 2px;
            transition: all 0.2s ease;
        }

        .fc-daygrid-event:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .fc-event-title {
            font-size: 11px;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .glass-card {
                padding: 30px 20px;
            }

            .provider-info {
                margin-bottom: 40px;
            }

            .services-grid {
                justify-content: center;
            }

            .calendar-section {
                padding: 30px 20px;
            }

            .modal-body {
                padding: 30px 20px;
            }

            .modal-header {
                padding: 30px 20px;
            }

            .modal-footer {
                padding: 30px 20px;
                flex-direction: column;
            }

            .calendar-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-input {
                padding: 15px 45px;
                font-size: 16px;
            }

            .search-btn {
                padding: 15px 25px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .provider-name {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .package-card {
                padding: 20px;
            }

            .glass-card {
                padding: 20px;
            }
        }
    </style>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedDate = null;
        let selectedPackage = null;

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
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: generateEvents(bookedDates),
                eventClick: function(info) {
                    if (info.event.extendedProps.available) {
                        selectedDate = info.event.startStr;
                        // Show package selection modal first
                        var packageModal = new bootstrap.Modal(document.getElementById(
                            'packageSelectionModal'));
                        packageModal.show();
                    }
                },
                eventMouseEnter: function(info) {
                    info.el.style.cursor = info.event.extendedProps.available ? 'pointer' : 'default';
                },
                height: 'auto',
                contentHeight: 'auto',
                aspectRatio: 1.8
            });

            // Render calendar with slight delay to ensure proper initialization
            setTimeout(() => {
                calendar.render();
            }, 100);

            // Package selection handlers
            document.querySelectorAll('.package-selection-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Remove selected class from all cards
                    document.querySelectorAll('.package-selection-card').forEach(c => c.classList
                        .remove('selected'));

                    // Add selected class to clicked card
                    this.classList.add('selected');

                    // Update button text
                    document.querySelectorAll('.select-this-package').forEach(btn => {
                        btn.innerHTML =
                            '<i class="fas fa-check-circle"></i> Select This Package';
                    });

                    this.querySelector('.select-this-package').innerHTML =
                        '<i class="fas fa-star"></i> Selected';
                });
            });

            // Handle package selection
            document.querySelectorAll('.select-this-package').forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.package-selection-card');
                    selectedPackage = {
                        id: card.dataset.packageId,
                        name: card.dataset.packageName,
                        price: card.dataset.packagePrice
                    };

                    // Close package selection modal
                    bootstrap.Modal.getInstance(document.getElementById('packageSelectionModal'))
                        .hide();

                    // Open booking modal
                    setTimeout(() => {
                        openBookingModal();
                    }, 300);
                });
            });

            // Enhanced floating labels
            document.querySelectorAll('.floating-label .form-control').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
            });

            // Enhanced button interactions
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    let ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);

                    let x = e.clientX - e.target.offsetLeft;
                    let y = e.clientY - e.target.offsetTop;

                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;

                    setTimeout(() => {
                        ripple.remove();
                    }, 300);
                });
            });
        });

        function openBookingModal() {
            if (!selectedPackage) return;

            // Set package data
            document.getElementById('selected_package_id').value = selectedPackage.id;

            // Set the date
            if (selectedDate) {
                document.getElementById('booking_date').value = selectedDate;
            }

            // Show selected package summary
            document.getElementById('selectedPackageSummary').style.display = 'block';
            document.getElementById('summaryPackageName').textContent = selectedPackage.name;
            document.getElementById('summaryPackagePrice').textContent = `${parseFloat(selectedPackage.price).toFixed(2)}`;

            // Update booking button
            document.getElementById('bookingTotal').textContent = `(${parseFloat(selectedPackage.price).toFixed(2)})`;

            // Update modal title
            document.querySelector('#bookingModal .modal-title').innerHTML = `
                <i class="fas fa-calendar-check"></i>
                Book ${selectedPackage.name}
            `;

            // Open booking modal
            var bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            bookingModal.show();
        }

        function changePackage() {
            // Close booking modal
            bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();

            // Open package selection modal
            setTimeout(() => {
                var packageModal = new bootstrap.Modal(document.getElementById('packageSelectionModal'));
                packageModal.show();
            }, 300);
        }


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
                        color: '#10b981',
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
        const card = elements.create('card', {
            hidePostalCode: true,
            style: {
                base: {
                    color: '#f9fafb',
                    fontFamily: 'Inter, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#9ca3af',
                    },
                },
                invalid: {
                    color: '#ef4444',
                    iconColor: '#ef4444',
                },
            },
        });
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            // Show loading state
            submitButton.classList.add('loading');
            submitButton.disabled = true;

            const packageId = document.getElementById('selected_package_id').value;

            if (!packageId) {
                alert('Please select a package first');
                submitButton.classList.remove('loading');
                submitButton.disabled = false;
                return;
            }

            try {
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
                    throw new Error("Payment error: " + text);
                }

                const data = await response.json();

                if (data.error) {
                    throw new Error(data.error);
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
                    throw new Error(result.error.message);
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
            } catch (error) {
                document.getElementById('card-errors').textContent = error.message;
                submitButton.classList.remove('loading');
                submitButton.disabled = false;
            }
        });

        // Handle direct package selection (from package cards)
        document.querySelectorAll('.select-package-btn').forEach(button => {
            button.addEventListener('click', function() {
                selectedPackage = {
                    id: this.dataset.packageId,
                    name: this.dataset.packageName,
                    price: this.dataset.packagePrice
                };

                openBookingModal();
            });
        });

        // Enhanced card element styling
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
                displayError.style.display = 'block';
            } else {
                displayError.textContent = '';
                displayError.style.display = 'none';
            }
        });

        // Handle modal cleanup
        document.getElementById('packageSelectionModal').addEventListener('hidden.bs.modal', function() {
            // Reset selection if no package was chosen
            document.querySelectorAll('.package-selection-card').forEach(card => {
                card.classList.remove('selected');
            });
            document.querySelectorAll('.select-this-package').forEach(btn => {
                btn.innerHTML = '<i class="fas fa-check-circle"></i> Select This Package';
            });
        });

        document.getElementById('bookingModal').addEventListener('hidden.bs.modal', function() {
            // Reset form
            document.getElementById('payment-form').reset();
            document.getElementById('card-errors').textContent = '';
            document.getElementById('card-errors').style.display = 'none';

            // Reset loading state
            submitButton.classList.remove('loading');
            submitButton.disabled = false;

            // Clear selected package data
            selectedPackage = null;
            selectedDate = null;

            // Hide package summary
            document.getElementById('selectedPackageSummary').style.display = 'none';
        });
    </script>

@endsection
