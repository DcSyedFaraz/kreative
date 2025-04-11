@extends('admin.layouts.app')
@section('content')
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-xxl">

                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0">Range Area Charts {{auth()->user()->getRoleNames()}}</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Charts</a></li>
                                <li class="breadcrumb-item active">Range Area Charts</li>
                            </ol>
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

                        <!-- Combo Range Area Chart -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Combo Range Area</h5>
                                </div>

                                <div class="card-body">
                                    <div id="cambo_rangearea_chart" class="apex-charts"></div>
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
                            &copy; <script>document.write(new Date().getFullYear())</script> - Made with <span class="mdi mdi-heart text-danger"></span> by <a href="#!" class="text-reset fw-semibold">Zoyothemes</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>


@endsection
