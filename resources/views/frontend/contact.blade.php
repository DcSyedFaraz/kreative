@extends('frontend.layout.app')
@section('title', 'Contact Us')
@section('content')

<section class="inner-page-main">
    <section class="inner-page-sec1">
        <div class="container">
            <div class="main-heading">
                <h2>Contact <span class="highlight">us</span></h2>
            </div>
        </div>
    </section>
    <section class="contact-sec2">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-md-4">
                    <div class="contact-info">
                        <hr class="redline">
                        <h4>Find us Here</h4>
                        <ul>
                            <li>774 NE 84th St Miami, FL 12345</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <hr class="redline">
                        <h4>Get In touch</h4>
                        <ul>
                            <li><a href="tel:+1 (000) 4567 4561">+1 (000) 4567 4561</a></li>
                            <li><a href="mailto:alisq26@gmail.com">alisq26@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <hr class="redline">
                        <h4>Training Hours</h4>
                        <ul>
                            <li>Mon- Fri: 9am- 8pm</li>
                            <li>Saturday: 10am-4pm</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-sec3">
        <div class="container">
            <form>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" class="inputfield" name="fname" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="inputfield" name="lname" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="tel" class="inputfield" name="phone" placeholder="*Phone Number" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="inputfield" name="email" placeholder="*Email Address" required>
                    </div>
                    <div class="col-md-12">
                        <textarea name="msg" id="" class="msgfield" placeholder="Leave a message"></textarea>
                        <input type="submit" class="sendbtn" value="Send">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="contact-sec4">

        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28724.024107463872!2d-80.180045!3d25.852917!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b22c59057bf1%3A0x7977972d22752b33!2s774%20NE%2084th%20St%2C%20Miami%2C%20FL%2033138!5e0!3m2!1sen!2sus!4v1742794202411!5m2!1sen!2sus" width="100%" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>    </section>
</section>
@endsection
