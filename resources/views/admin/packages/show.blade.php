@extends('admin.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h2 class="fw-semibold mb-5">Package Show</h2>
                    </div>
                </div>
                <!-- Button Datatable -->
                <div class="row">
                    <div class="col-12">
                        <div class="container">
                            <h4><strong>Name : </strong>{{ $package->name }}</h4>  <br>
                            <h4><strong>Description : </strong>{{ $package->description }}</h4> <br>
                            <h4><strong>Price : </strong>{{ $package->price }}</h4> <br>
                            <h4><strong>Features: </strong>  {{ $selectedPackage->flatten()->implode(', ') }}</h4>

                            <a href="{{ route('packages.index') }}" class="btn btn-danger mt-5">Cancel</a>
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
