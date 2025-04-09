@extends('frontend.layout.app')
@section('title', 'Collaboration')
@section('content')

<section class="inner-page-main">
    <section class="inner-page-sec1">
        <div class="container">
            <div class="main-heading">
                <h2>Collabora<span class="highlight">tion</span></h2>
            </div>
        </div>
    </section>
    <section class="sec5">
        <div class="container">
            <div class="sec5cntnt">
                <h5 class="redhead">COLLABORATION VIEW</h5>
                <h3>COLLABORATIONS</h3>
                <p>Whatever the mind can conceive and believe, it can achieve and we can be help you along the
                    way. Be on the same page always with your Creative Service Providers and actually get
                    projects done according to your vision. </p>
            </div>
            <div class="row align-items-start">
                <div class="col-md-4">
                    <div class="firstcolimg">
                        <img src="{{ asset('assets/images/frontend/collab4.webp') }} " alt="">
                        <img src="{{ asset('assets/images/frontend/main-bg.webp') }} " alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="secondcolimgs">
                        <img src="{{ asset('assets/images/frontend/collab1.webp') }} " alt="">
                        <img src="{{ asset('assets/images/frontend/collab5.webp') }} " alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thirdcolimg">
                        <img src="{{ asset('assets/images/frontend/collab2.webp') }} " alt="">
                        <img src="{{ asset('assets/images/frontend/collab3.webp') }} " alt="">
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
                                <img src="{{ asset('assets/images/frontend/brand1.webp') }} " alt="">
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
</section>
@endsection
