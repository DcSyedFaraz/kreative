<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kreative</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/frontend/logo.webp') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Font Awesome 6 Free (includes solid icons with "fas" prefix) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- jquerry --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body data-menu-color="dark" data-sidebar="default">

    <div id="app-layout">
        <!-- Left Sidebar Start -->
        <div class="app-sidebar-menu">

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <div class="logo-box">
                    <a class="logo logo-light" href="/">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/frontend/logo.webp') }}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/frontend/logo.webp') }}" alt="" height="50">
                        </span>
                    </a>
                    <a class="logo logo-dark" href="/">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/frontend/logo.webp') }}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/frontend/logo.webp') }}" alt="" height="50">
                        </span>
                    </a>
                </div>

                @if (Auth::user()->hasRole('admin'))
                    @include('admin.layouts.sidebar.admin')
                @elseif (Auth::user()->hasRole('user'))
                    @include('admin.layouts.sidebar.user')
                @elseif (Auth::user()->hasRole('service provider'))
                    @include('admin.layouts.sidebar.service_provider')
                @endif

            </div>
            <!-- Begin page -->
        </div>

        <div class="content-page">
            @yield('content')
        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col fs-13 text-muted text-center">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script> - Made with <span class="mdi mdi-heart text-danger"></span> by <a
                        href="#!" class="text-reset fw-semibold">Zoyothemes </a>
                </div>
            </div>
        </div>
    </footer>
    {{-- @dd(auth()->user()->roles()) --}}
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- Apexcharts JS -->
    {{-- <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    <!-- Range Area Chart Init Js -->
    {{-- <script src="{{ asset('assets/js/pages/apexcharts-range-area.init.js') }}"></script> --}}
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        @if (session('success'))
            console.log('{{ session('success') }}');

            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    @stack('scripts')
</body>

</html>
