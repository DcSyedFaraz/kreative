@extends('admin.layouts.app')
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div
                        class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Available Services</h5>
                        <a href="{{ route('profile.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Profile
                        </a>
                    </div>

                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('services.update') }}" method="POST">
                            @csrf

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Service</th>
                                            <th class="text-center">Offer This Service</th>
                                            <th class="text-center">Display on Profile</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allServices as $service)
                                            <tr class="border-bottom">
                                                <td class="ps-3">
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold text-capitalize text-dark">{{ $service->name }}</span>
                                                        @if ($service->description)
                                                            <span
                                                                class="text-muted small">{{ $service->description }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch d-flex justify-content-center">
                                                        <input class="form-check-input service-checkbox" type="checkbox"
                                                            name="services[]" value="{{ $service->id }}"
                                                            id="service{{ $service->id }}"
                                                            {{ in_array($service->id, $userServices) ? 'checked' : '' }}
                                                            style="transform: scale(1.2);">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch d-flex justify-content-center">
                                                        <input class="form-check-input display-checkbox" type="checkbox"
                                                            name="display_services[]" value="{{ $service->id }}"
                                                            id="display{{ $service->id }}"
                                                            {{ in_array($service->id, $userServices) && $user->services->where('id', $service->id)->first()->pivot->display_on_profile ? 'checked' : '' }}
                                                            {{ !in_array($service->id, $userServices) ? 'disabled' : '' }}
                                                            style="transform: scale(1.2);">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(to right, #4e73df, #224abe);
        }

        .form-check-input:checked {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .table th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card {
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            box-shadow: 0 2px 6px rgba(78, 115, 223, 0.3);
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
            transform: translateY(-1px);
        }

        .btn-light {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Enable/disable display checkboxes based on service selection
        document.addEventListener('DOMContentLoaded', function() {
            const serviceCheckboxes = document.querySelectorAll('.service-checkbox');

            serviceCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const serviceId = this.value;
                    const displayCheckbox = document.querySelector(`#display${serviceId}`);

                    if (this.checked) {
                        displayCheckbox.disabled = false;
                    } else {
                        displayCheckbox.checked = false;
                        displayCheckbox.disabled = true;
                    }
                });
            });

            // Add animation to success message
            const alertSuccess = document.querySelector('.alert-success');
            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.classList.add('fade');
                    setTimeout(() => {
                        alertSuccess.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endsection
