@extends('frontend.layout.app')
@section('title', 'Sign Up')
@section('content')

    <section class="inner-page-main">
        <section class="inner-page-sec1">
            <div class="container">
                <div class="main-heading">
                    <h2>Sign Up</h2>
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
                        <form method="POST" action="{{ route('register') }}" class="userform">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close"
                                    data-dismiss="alert">×</button>
                                <strong>{{ $errors->first() }}</strong>
                            </div>
                        @endif
                            @csrf
                            <div class="row align-items-center">
                                <h2 class="form-mainhead">User</h2>
                                <div class="col-md-12">
                                    <label for="u-username">Username</label>
                                    <input type="text" class="inputfield" id="u-username" name="username" placeholder=""
                                        required>
                                        @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="u-fname">First Name</label>
                                    <input type="text" class="inputfield" id="u-fname" name="fname" placeholder=""
                                        required>
                                        @error('fname')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="u-lname">Last Name</label>
                                    <input type="text" class="inputfield" id="u-lname" name="lname" placeholder=""
                                        required>
                                        @error('lname')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="u-email">E-mail Address</label>
                                    <input type="email" class="inputfield" id="u-email" name="email" placeholder=""
                                        required>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="u-pass">Password</label>
                                    <input type="password" class="inputfield" id="u-pass" name="password" placeholder=""
                                        required>
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="u-conpass">Confirm Password</label>
                                    <input type="password" class="inputfield" id="u-conpass" name="password_confirmation"
                                        placeholder="Confirm Password" required>
                                        @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="regbtns">

                                        <input type="button" class="logbtn" value="Login" onclick="window.location.href='{{ route('login') }}'">
                                        <input type="submit" class="regbtn" value="Register">
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
                                    <label for="v-username">Username</label>
                                    <input type="text" class="inputfield" id="v-username" name="username" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="v-fname">First Name</label>
                                    <input type="text" class="inputfield" id="v-fname" name="fname" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="v-lname">Last Name</label>
                                    <input type="text" class="inputfield" id="v-lname" name="lname" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="v-email">E-mail Address</label>
                                    <input type="text" class="inputfield" id="v-email" name="email" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="v-pass">Password</label>
                                    <input type="text" class="inputfield" id="v-pass" name="pass" placeholder=""
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="v-conpass">Confirm Password</label>
                                    <input type="text" class="inputfield" id="v-conpass" name="confirmpass"
                                        placeholder="Confirm Password" required>
                                </div>
                                <div class="col-md-12">
                                    <div class="regbtns">
                                        <input type="submit" class="logbtn" value="Login">
                                        <input type="submit" class="regbtn" value="Register">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            </div>
        </section>
    </section>
@endsection
