<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }
    public function registration_pending()
    {
        if (auth()->check()) {
            if (auth()->user()->status === 'active') {
                return redirect()->route('login');
            }
        }
        return view('auth.registration_pending');
    }

    public function aboutus()
    {
        return view('frontend.about-us');
    }

    public function Service()
    {
        return view('frontend.service');
    }

    public function Contact()
    {
        return view('frontend.contact');
    }

    public function Collaboration()
    {
        return view('frontend.Collaboration');
    }
}
