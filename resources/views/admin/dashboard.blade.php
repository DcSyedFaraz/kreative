@extends('admin.layouts.app')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Range Area Charts </h4>
                </div>


            </div>

            <!-- Range Area Charts -->
            <div class="row">
                <!-- Basic Range Area Chart -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Basic Range Area</h5>
                        </div>

                        <div class="card-body">
                            <div id="basic_rangearea_chart" class="apex-charts"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div> <!-- container-fluid -->

    </div> <!-- content -->
    @if (auth()->user()->hasRole('admin'))
        <x-pending-users />
        @include('admin.partials.user-order')
    @elseif (auth()->user()->hasRole('service provider'))
        @include('admin.partials.user-order')
    @endif
@endsection



@push('scripts')
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });


        $('#payments-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('payments.get') }}',
                data: {
                    type: 'payment'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'package_id',
                    name: 'package_id'
                },
                {
                    data: 'booking_id',
                    name: 'booking_id'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'payment_status',
                    name: 'payment_status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });


        $('#bookings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('payments.get') }}',
                data: {
                    type: 'booking'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'package_id',
                    name: 'package_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'booking_date',
                    name: 'booking_date'
                },
            ]
        });
    </script>
@endpush
