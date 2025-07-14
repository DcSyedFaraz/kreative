@extends('admin.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold mb-5">Package Show</h4>
                    </div>
                </div>
                <!-- Button Datatable -->
                <div class="row">
                    <div class="col-12">
                        <div class="container">
                            <h5>Name : {{ $package->name }}</h5>
                            <h5>Description : {{ $package->description }}</h5> <br>
                            <h5>Price : {{ $package->price }}</h5> <br>
                            <p><strong>Features:</strong> <br> {{ $selectedPackage->flatten()->implode(', ') }}</p>

                            <a href="{{ route('packages.index') }}" class="btn btn-danger">Cancel</a>
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

    </div>
@endsection
