@extends('frontend.layout.app')
@section('title', 'About Us')
@section('content')
<section class="inner-page-main">
    <section class="inner-page-sec1">
        <div class="container">
            <div class="main-heading">
                <h2>About <span class="highlight">Us</span></h2>
            </div>
        </div>
    </section>
    <section class="sec3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="about-img">
                        <img src="{{ asset('assets/images/frontend/collab2.webp') }}" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-content">
                        <h5 class="redhead">ABOUT US</h5>
                        <h3>ALI QURESHI</h3>
                        <p>Connecting with others and solidifying deeper relationships by personalization is my
                            bread
                            and butter – Executive Salesman for tech companies like Google Cloud, NTT Data and
                            (currently) Dell Technologies, I totally understand the importance of personalization
                            and
                            being collaborative is key for success. </p>
                        <p>Intertwining my professional experience with a creative eureka moment, I decided that why
                            not
                            I help businesses, influencers and other creative persons to build deeper relationships
                            with
                            their audiences with their creative pursuits.
                        </p>
                        <h6>Kreative Connects Collaborations: </h6>
                        <p>Booking and collaboration platform, that connects Creative Service Providers
                            (Photographers, Videographers, Directors, Producers, Editors, and Artists) with clients
                            end-to-end (meaning: bookings to collaboration outlet) online.
                        </p>
                        <p>So showcase your vision, don’t just tell them!</p>
                        <p>Wether it’s:</p>
                        <ul>
                            <li>Engaging Learning & Development for your employees</li>
                            <li>Creating engaging content that provides value for the audiences on socials for
                                generating more revenue</li>
                            <li>Corporate & office events</li>
                            <li>Influencers want a personal videographer and other creative services to capture
                                their
                                moments to connect and grow following base</li>
                            <li>Creative person wanting showcase their talent to the world and build relationships
                                with
                                their own tribe</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sec6">
        <div class="container">
            <div class="row align-items-center">
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
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/frontend/testi.webp') }}" alt="">
                </div>
            </div>
        </div>
        </div>
    </section>
</section>


@endsection
