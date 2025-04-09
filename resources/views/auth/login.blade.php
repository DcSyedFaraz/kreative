@extends('frontend.layout.app')
@section('title', 'Login')
@section('content')
    <section class="inner-page-main">
        <section class="inner-page-sec1">
            <div class="container">
                <div class="main-heading">
                    <h2>LOGIN</h2>
                </div>
            </div>
        </section>
        <section class="contact-sec3">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="user-tab" data-bs-toggle="tab"
                            data-bs-target="#user-tab-pane" type="button" role="tab" aria-controls="user-tab-pane"
                            aria-selected="true">User</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vendor-tab" data-bs-toggle="tab" data-bs-target="#vendor-tab-pane"
                            type="button" role="tab" aria-controls="vendor-tab-pane"
                            aria-selected="false">Vendor</button>
                    </li>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="user-tab-pane" role="tabpanel" aria-labelledby="user-tab"
                        tabindex="0">
                        <form method="POST" action="{{ route('login') }}" class="userform">
                            @csrf
                            <div class="row align-items-center">
                                <h2 class="form-mainhead">User</h2>
                                <div class="col-md-12">
                                    <label for="user">Username or E-mail</label>
                                    <input type="email" class="inputfield" id="user" name="email" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="pass">Password</label>
                                    <input type="password" class="inputfield" id="pass" name="password" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <div class="chckbx">
                                        <input type="checkbox" name="checkbox" id="signed">
                                        <label for="signed">Keep me signed in</label>
                                    </div>
                                    <div class="regbtns">
                                        <input type="submit" class="logbtn" value="Login">
                                        <input type="button" class="regbtn" value="Register" onclick="window.location.href='{{route('register')}}'">
                                    </div>
                                    <div class="forgot">
                                        <a href="#" class="frgt">Forgot your password?</a>
                                        <a href="{{ route('register') }}" class="signupbtn">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="vendor-tab-pane" role="tabpanel" aria-labelledby="vendor-tab"
                        tabindex="0">
                        <form class="vendorform">
                            <div class="row align-items-center">
                                <h2 class="form-mainhead">Vendor</h2>
                                <div class="col-md-12">
                                    <label for="vuser">Username or E-mail</label>
                                    <input type="text" class="inputfield" id="vuser" name="fname" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="vpass">Password</label>
                                    <input type="text" class="inputfield" id="vpass" name="fname" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <div class="chckbx">
                                        <input type="checkbox" name="checkbox" id="vsigned">
                                        <label for="vsigned">Keep me signed in</label>
                                    </div>
                                    <div class="regbtns">
                                        <input type="submit" class="logbtn" value="Login">
                                        <input type="submit" class="regbtn" value="Register">
                                    </div>
                                    <div class="forgot">
                                        <a href="#" class="frgt">Forgot your password?</a>
                                        <a href="sign-up.html" class="signupbtn">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
  @endsection
