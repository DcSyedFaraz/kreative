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
    @endif
    <!-- Footer Start -->

    <!-- end Footer -->
@endsection
