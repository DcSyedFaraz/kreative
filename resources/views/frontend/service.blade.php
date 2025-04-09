@extends('frontend.layout.app')
@section('title', 'Service')
@section('content')
<section class="inner-page-main">
    <section class="inner-page-sec1">
        <div class="container">
            <div class="main-heading">
                <h2>Our <span class="highlight">Services</span></h2>
            </div>
        </div>
    </section>
    <section class="sec4">
        <div class="container">
            <div class="sec4head">
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
            </div>
        </div>
    </section>
</section>
@endsection
