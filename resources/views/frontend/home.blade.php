@extends('frontend.layout.app')
@section('title', 'Ali Qureshi')
@section('content')

    <section class="sec1">
        <div class="owl-carousel owl-theme main-caro">
            <div class="item">
                <div class="container">
                    <div class="main-banner-content">
                        <h5 class="redhead">WELCOME TO KREATIVE CONNECTS</h5>
                        <h2>UNLEASH <br> YOUR KREATIVITY!</h2>
                        <p>Book creative service providers (Photographers, Videographers, Directors, Producers,
                            Editors,Artists) by session on our page</p>
                        <a href="#" class="gsbtn">Get Start Now <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container">
                    <div class="main-banner-content">
                        <h5 class="redhead">WELCOME TO KREATIVE CONNECTS</h5>
                        <h2>UNLEASH <br> YOUR KREATIVITY!</h2>
                        <p>Book creative service providers (Photographers, Videographers, Directors, Producers,
                            Editors,Artists) by session on our page</p>
                        <a href="#" class="gsbtn">Get Start Now <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container">
                    <div class="main-banner-content">
                        <h5 class="redhead">WELCOME TO KREATIVE CONNECTS</h5>
                        <h2>UNLEASH <br> YOUR KREATIVITY!</h2>
                        <p>Book creative service providers (Photographers, Videographers, Directors, Producers,
                            Editors,Artists) by session on our page</p>
                        <a href="#" class="gsbtn">Get Start Now <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sec2">
        <div class="container">
            <div class="inner-sec2">
                <h3>TRUSTED BY <span>200+</span> FORWARD THINKING COMPANIES.</h3>
                <section class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide">
                                <img src="{{ asset('assets/images/frontend/brand1.webp') }}" alt="">
                            </li>
                            <li class="splide__slide">
                                <img src="{{ asset('assets/images/frontend/brand2.webp') }}" alt="">
                            </li>
                            <li class="splide__slide">
                                <img src="{{ asset('assets/images/frontend/brand3.webp') }}" alt="">
                            </li>
                            <li class="splide__slide">
                                <img src="{{ asset('assets/images/frontend/brand4.webp') }}" alt="">
                            </li>
                            <li class="splide__slide">
                                <img src="{{ asset('assets/images/frontend/brand5.webp') }}" alt="">
                            </li>
                            <li class="splide__slide">
                                <img src="{{ asset('assets/images/frontend/brand6.webp') }}" alt="">
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <section class="sec3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="about-img">
                        <div class="img-one">
                            <img src="{{ asset('assets/images/frontend/aboutimg1.webp') }}" alt="">
                            <a href="#" class="play"><i class="fa-light fa-play"></i></a>
                        </div>
                        <div class="img-two">
                            <img class="secimg" src="{{ asset('assets/images/frontend/aboutimg2.webp') }}" alt="">
                            <img src="{{ asset('assets/images/frontend/aboutimg3.webp') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-content">
                        <h5 class="redhead">ABOUT US</h5>
                        <h3>ALI QURESHI</h3>
                        <p>Connecting with others and solidifying deeper relationships by personalization is my bread
                            and butter – Executive Salesman for tech companies like Google Cloud, NTT Data and
                            (currently) Dell Technologies, I totally understand the importance of personalization and
                            being collaborative is key for success. </p>
                        <p>Intertwining my professional experience with a creative eureka moment, I decided that why not
                            I help businesses, influencers and other creative persons to build deeper relationships with
                            their audiences with their creative pursuits.
                        </p>
                        <h6>Kreative Connects Collaborations: </h6>
                        <a href="about.html" class="lm">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sec4">
        <div class="container">
            <div class="sec4head">
                <h5 class="redhead">OUR SERVICES</h5>
                <h3>OUR SERVICES</h3>
            </div>
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="service-bx">
                        <div class="ser-icon">
                            <img src="{{ asset('assets/images/frontend/icon1.png') }}" alt="">
                        </div>
                        <div class="ser-cntnt">
                            <h4>VIDEOGRAPHERS</h4>
                            <p>lorem sit psum dolor amet congu elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-bx">
                        <div class="ser-icon">
                            <img src="{{ asset('assets/images/frontend/icon2.png') }}" alt="">
                        </div>
                        <div class="ser-cntnt">
                            <h4>CREATIVE PERSONS</h4>
                            <p>lorem sit psum dolor amet congu elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-bx">
                        <div class="ser-icon">
                            <img src="{{ asset('assets/images/frontend/icon3.png') }}" alt="">
                        </div>
                        <div class="ser-cntnt">
                            <h4>PHOTOGRAPHERS</h4>
                            <p>lorem sit psum dolor amet congu elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-bx">
                        <div class="ser-icon">
                            <img src="{{ asset('assets/images/frontend/icon4.png') }}" alt="">
                        </div>
                        <div class="ser-cntnt">
                            <h4>DIRECTORS</h4>
                            <p>lorem sit psum dolor amet congu elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-bx">
                        <div class="ser-icon">
                            <img src="{{ asset('assets/images/frontend/icon1.png') }}" alt="">
                        </div>
                        <div class="ser-cntnt">
                            <h4>PRODUCERS</h4>
                            <p>lorem sit psum dolor amet congu elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-bx">
                        <div class="ser-icon">
                            <img src="{{ asset('assets/images/frontend/icon6.png') }}" alt="">
                        </div>
                        <div class="ser-cntnt">
                            <h4>ARTISTS</h4>
                            <p>lorem sit psum dolor amet congu elit.</p>
                        </div>
                    </div>
                </div>
                <div class="sec4btns">
                    <a href="service.html" class="dm">Discover More <i class="fa-solid fa-plus"></i></a>
                    <a href="contact.html" class="gsbtn">Get Start Now <i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
    </section>
    <section class="sec5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="sec5cntnt">
                        <h5 class="redhead">COLLABORATION VIEW</h5>
                        <h3>COLLABORATIONS</h3>
                        <p>Whatever the mind can conceive and believe, it can achieve and we can be help you along the
                            way. Be on the same page always with your Creative Service Providers and actually get
                            projects done according to your vision. </p>
                    </div>
                    <img src="{{ asset('assets/images/frontend/collab1.webp') }}" alt="">
                    <div class="firstcolimgs">
                        <img src="{{ asset('assets/images/frontend/collab2.webp') }}" alt="">
                        <img src="{{ asset('assets/images/frontend/collab3.webp') }}" alt="">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="secondcolimgs">
                        <img src="{{ asset('assets/images/frontend/collab4.webp') }}" alt="">
                        <img src="{{ asset('assets/images/frontend/collab5.webp') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sec6">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <img src="{{ asset(path: 'assets/images/frontend/testi.webp') }}" alt="">
                </div>
                <div class="col-md-7">
                    <div class="testi">
                        <div class="sec5cntnt">
                            <h5 class="redhead">TESTIMONIALS</h5>
                            <h3>CLIENT VIEW</h3>
                        </div>
                        <div class="owl-carousel owl-theme testimonial">
                            <div class="item">
                                <div class="testicntnt">
                                    <p>
                                        "Aliquam sed nisi eu eros tristique scelerisque. Aliquam eu tellus quis
                                        lacus luctus cursus. Aenean dapibus lacus vitae lobortis aliquam. Cras susci
                                        eros lacus, condimentum porta odio hendrerit vel. Sed ultricesque."</p>
                                    <div class="stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h5 class="redhead">WALTER WHITE - CEO</h5>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testicntnt">
                                    <p>
                                        "Aliquam sed nisi eu eros tristique scelerisque. Aliquam eu tellus quis
                                        lacus luctus cursus. Aenean dapibus lacus vitae lobortis aliquam. Cras susci
                                        eros lacus, condimentum porta odio hendrerit vel. Sed ultricesque."</p>
                                    <div class="stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h5 class="redhead">WALTER WHITE - CEO</h5>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testicntnt">
                                    <p>
                                        "Aliquam sed nisi eu eros tristique scelerisque. Aliquam eu tellus quis
                                        lacus luctus cursus. Aenean dapibus lacus vitae lobortis aliquam. Cras susci
                                        eros lacus, condimentum porta odio hendrerit vel. Sed ultricesque."</p>
                                    <div class="stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h5 class="redhead">WALTER WHITE - CEO</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection
