<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/frontend/logo.webp') }}">
    <title> @yield('title')</title>
</head>

<body>
    <header class="header">
        <nav class="navbar-light navbar-expand-lg">
            <div class="container d-block">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-6 px-3">
                        <a href="index.html">
                            <img class="navlogo" src="{{ asset('assets/images/frontend/logo.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="col-lg-8 col-md-8 d-none d-md-block d-lg-block px-3">
                        <div class="navbar">
                            <div class="nav-up">
                                <ul class="nav-ul">
                                    <li><a class="list active" href="{{ route('home') }}">Home</a></li>
                                    <li><a class="list" href="{{ route('about-us') }}">About Us</a></li>
                                    <li><a class="list" href="{{ route('service') }}">Our Services</a></li>
                                    <li><a class="list" href="{{ route('collaboration') }}">Collaboration</a></li>
                                    <li><a class="list" href="{{ route('contact') }}">Contact Us</a></li>
                                    <li><a class="list" href="{{ route('service-providers.search') }}">Service
                                            Provider</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-2 col-md-2 d-none d-md-block d-lg-block px-3">
                        <div class="loginbtns">
                            <a class="login" href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                    <div class="col-6 d-lg-none d-md-none d-block">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div class="offcanvas offcanvas-end bg-secondary secondary-1" id="navbarOffcanvas"
                            tabindex="-1" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <a class="navbar-brand" href="index.html"><img
                                        src="{{ asset('') }}assets/images/frontend/phone-logo.png" alt="logo"
                                        class="logo"></a>
                                <button type="button" class="btn-close btn-close-black text-reset"
                                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <div class="nav-up">
                                        <ul class="nav-ul">
                                            <li><a class="list active" href="index.html">Home</a></li>
                                            <li><a class="list" href="about.html">About Us</a></li>
                                            <li><a class="list" href="service.html">Our Services</a></li>
                                            <li><a class="list" href="collaboration.html">Collaboration</a></li>
                                            <li><a class="list" href="contact.html">Contact Us</a></li>
                                        </ul>
                                    </div>
                                    <div class="loginbtns">
                                        <a class="login" href="login.html">Login</a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </nav>
    </header>
    @yield('content')

    <footer>
        </div>
        <div class="Main-foot">
            <div class="container">
                <div class="inner-white-bx">
                    <div class="white-bx">
                        <i class="fa-brands fa-facebook-f"></i>
                        <h4>FACEBOOK</h4>
                    </div>
                    <div class="white-bx">
                        <i class="fa-brands fa-instagram"></i>
                        <h4>INSTAGRAM</h4>
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col-md-4">
                        <div class="firstcol">
                            <img src="{{ asset('assets/images/frontend/logo.webp') }}" alt="">
                            <p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT, SED DO EIUSMOD TEMPOR INCIDIDUNT
                                UT LABORE ET DOLORE MAGNA ALIQUA.
                            </p>
                            <ul class="footul">
                                <li><i class="fa-solid fa-location-dot"></i><a href="#"> 774 NE 84th St Miami,
                                        FL
                                        12345</a></li>
                                <li><i class="fa-solid fa-phone"></i><a href="#"> +1 (000) 4567 4561</a></li>
                                <li><i class="fa-solid fa-envelope"></i><a href="#"> alisq26@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="secondcol">
                            <h4>Useful Link</h4>
                            <ul class="footul">
                                <li><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-right"></i> Home</a>
                                </li>
                                <li><a href="{{ route('about-us') }}"><i class="fa-solid fa-chevron-right"></i>
                                        About</a></li>
                                <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Client View Page</a>
                                </li>
                                <li><a href="{{ route('service') }}"><i class="fa-solid fa-chevron-right"></i>
                                        Services Provider Page</a>
                                </li>
                                <li><a href="{{ route('collaboration') }}"><i class="fa-solid fa-chevron-right"></i>
                                        Collaboration View</a></li>
                                <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Shopping Cart</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thirdcol">
                            <h4>Useful Link</h4>
                            <div class="prdct">
                                <div class="prdctimg">
                                    <img src="{{ asset('assets/images/frontend/foot1.webp') }}" alt="">
                                </div>
                                <div class="prdctdesc">
                                    <h5>Lorem Psum Elit</h5>
                                    <p>$ 1, 800,000</p>
                                </div>
                            </div>
                            <div class="prdct">
                                <div class="prdctimg">
                                    <img src="{{ asset('assets/images/frontend/foot1.webp') }}" alt="">
                                </div>
                                <div class="prdctdesc">
                                    <h5>Lorem Psum Elit</h5>
                                    <p>$ 1, 800,000</p>
                                </div>
                            </div>
                            <div class="prdct">
                                <div class="prdctimg">
                                    <img src="{{ asset('assets/images/frontend/foot1.webp') }}" alt="">
                                </div>
                                <div class="prdctdesc">
                                    <h5>Lorem Psum Elit</h5>
                                    <p>$ 1, 800,000</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="inner-copyright">
                    <div class="reserve">
                        <p>Design Engineered, Developed, Deployed & Maintained By <span class="highlight">Digital Nest
                                Studio</span> Copyright © 2025. Ali Qureshi</p>
                    </div>
                    <div class="socials">
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-instagram"></i>
                        <i class="fa-brands fa-x-twitter"></i>
                        <i class="fa-brands fa-pinterest"></i>
                    </div>
                </div>
            </div>

        </div>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
</script>

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
<script>
    $('.main-caro').owlCarousel({
        loop: true,
        navText: ["<i class='fa-solid fa-chevron-left'></i>", "<i class='fa-solid fa-chevron-right'></i>"],
        margin: 0,
        nav: true,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
</script>


<script>
    $('.testimonial').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elms = document.getElementsByClassName('splide');

        for (var i = 0; i < elms.length; i++) {
            new Splide(elms[i], {
                type: 'loop',
                drag: 'free',
                focus: 'center',
                perPage: 6,
                autoScroll: {
                    speed: 0.7,
                    pauseOnHover: false,
                    pauseOnFocus: false,
                },
            }).mount(window.splide.Extensions);
        }
    });
</script>

</html>
