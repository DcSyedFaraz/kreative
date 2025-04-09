<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

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
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="24">
                        </span>
                    </a>
                    <a class="logo logo-dark" href="/">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="24">
                        </span>
                    </a>
                </div>

                <ul id="side-menu-baer">
                    <li class="menu-title">Menu</li>
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i data-feather="home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}">
                            <i data-feather="aperture"></i>
                            <span> Roles </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i data-feather="globe"></i>
                            <span> User </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
                        <a href="{{ route('product.index') }}">
                            <i data-feather="globe"></i>
                            <span> Product </span>
                        </a>
                    </li>
                    <li>
                        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn btn-danger" style="margin-left:15px;">
                            Logout
                        </button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>

            </div>
            <!-- Begin page -->
        </div>

        <div class="content-page">
            @yield('content')
        </div>
    </div>

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
    @yield('scripts')
</body>

</html>
