@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">Users Management</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New User
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Users List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Verified</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <!-- DataTables will auto-generate the body -->
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Global Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteModalForm" action="" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingOverlay"
        style="position: absolute; top: 0; left: 0;
     width: 100%; height: 100%; background-color: rgba(255,255,255,0.8);
     display: flex; align-items: center; justify-content: center; z-index: 9999;">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Ensure this script is placed after the table and modal markup
        $(document).on('click', '.btn-delete', function() {
            var route = $(this).data('route');
            $('#deleteModalForm').attr('action', route); // set the form action to the appropriate URL
            $('#deleteModal').modal('show'); // display the modal
        });

        $(document).ready(function() {
            var table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'email_verified_at',
                        name: 'email_verified_at',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'role',
                        name: 'role',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                // When initialization is complete, hide the overlay
                initComplete: function(settings, json) {
                    $('#loadingOverlay').fadeOut();
                }
            });
        });
    </script>
@endpush
