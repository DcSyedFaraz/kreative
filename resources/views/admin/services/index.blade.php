@extends('admin.layouts.app')
@section('content')

        <div class="content">
            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Service List</h4>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('available-services.create') }}" class="btn btn-warning">Create</a>
                    </div>
                </div>
                <!-- Button Datatable -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $id = 1;
                                        @endphp
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>{{ $id++ }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->description ?? '-' }} </td>
                                                <td>
                                                    <a href="{{ route('available-services.edit', $service->id) }}" type="button"
                                                        class="btn btn-secondary">Edit</a>
                                                </td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('available-services.destroy', $service->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('available-services.show', $service->id) }}"
                                                        class="btn btn-info">Show</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col fs-13 text-muted text-center">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script> - Made with <span class="mdi mdi-heart text-danger"></span> by <a
                            href="#!" class="text-reset fw-semibold">Zoyothemes</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->


@endsection
