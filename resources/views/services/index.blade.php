@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Available Services</span>
                        <a href="{{ route('profile.index') }}" class="btn btn-sm btn-secondary">Back to Profile</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('services.update') }}" method="POST">
                            @csrf

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Offer This Service</th>
                                            <th>Display on Profile</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allServices as $service)
                                            <tr>
                                                <td>
                                                    <strong>{{ $service->name }}</strong>
                                                    @if ($service->description)
                                                        <p class="text-muted small mb-0">{{ $service->description }}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input service-checkbox" type="checkbox"
                                                            name="services[]" value="{{ $service->id }}"
                                                            id="service{{ $service->id }}"
                                                            {{ in_array($service->id, $userServices) ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input display-checkbox" type="checkbox"
                                                            name="display_services[]" value="{{ $service->id }}"
                                                            id="display{{ $service->id }}"
                                                            {{ in_array($service->id, $userServices) && $user->services->where('id', $service->id)->first()->pivot->display_on_profile ? 'checked' : '' }}
                                                            {{ !in_array($service->id, $userServices) ? 'disabled' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        });
    </script>
@endsection
