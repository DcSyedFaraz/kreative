@extends('admin.layouts.app')
@section('content')

        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold mb-5">Service show</h4>
                    </div>
                </div>
                <!-- Button Datatable -->
                <div class="row">
                    <div class="col-12">
                        <div class="container">
                            <h5>Name : {{ $service->name }}</h5>
                            <h5>Description : {{ $service->description }}</h5>  <br>
                            <a href="{{ route('available-services.index') }}" class="btn btn-danger">Cancel</a>
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
