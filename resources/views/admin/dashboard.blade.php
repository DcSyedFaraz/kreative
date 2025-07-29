@extends('admin.layouts.app')
@section('content')
    @if (auth()->user()->hasRole('admin'))
        <x-pending-users />
    @endif
    @include('admin.partials.user-order')
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
                url: '{{ route('dashboard') }}',
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
                url: '{{ route('dashboard') }}',
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
        $('#custom-packages-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('dashboard') }}',
                data: {
                    type: 'custom-package'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'service_provider',
                    name: 'service_provider'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'price',
                    name: 'price'
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
    </script>
@endpush
