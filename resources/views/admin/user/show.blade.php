@extends('admin.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">User detail</h4> <br>
                    </div>
                </div>
                <!-- Button Datatable -->
                <div class="row">
                    <div class="col-12">
                        <h6> Name : {{ $user->name }}</h6> <br>

                        <h6> Email : {{ $user->email }}</h6> <br>

                        Role :
                        @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $v)
                                <label class="badge text-bg-dark mb-3"> {{ $v }}</label>
                            @endforeach
                        @endif

                        <br>

                        Permission :
                        @if (!empty($user->getAllPermissions()))
                            @foreach ($user->getAllPermissions() as $v)
                                <label class="badge text-bg-success mb-3"> {{ $v->name }}</label>
                            @endforeach
                        @endif

                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('users.index') }}" class="btn btn-danger">Cancel</a>
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
