@extends('admin.layouts.app')

@section('content')
    <div class="content">
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Package List</h4>
                </div>

                <div class="text-end">
                    <a href="{{ route('packages.create') }}" class="btn btn-warning">Create</a>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Features</th>
                                        <th>Actions</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $id = 1; @endphp
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td>{{ $id++ }}</td>
                                            <td>{{ $package->name }}</td>
                                            <td>{{ $package->description ?? '-' }}</td>
                                            <td>{{ number_format($package->price, 2) }}</td>
                                            <td>
                                                <ul class="mb-0">
                                                    @foreach ($package->items as $item)
                                                        <li>{{ $item->features }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="{{ route('packages.edit', $package->id) }}"
                                                    class="btn btn-secondary">Edit</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('packages.show', $package->id) }}"
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
        </div> <!-- container-xxl -->
    </div> <!-- content -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col fs-13 text-muted text-center">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script> - Made with ❤️ by <a href="#!"
                        class="text-reset fw-semibold">Zoyothemes</a>
                </div>
            </div>
        </div>
    </footer>
@endsection
