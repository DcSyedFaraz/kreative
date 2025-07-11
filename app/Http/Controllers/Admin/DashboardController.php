<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $payments = Payment::with('user', 'package', 'booking')->get();
        $bookings = Booking::with('user', 'package')->get();
        return view('admin.dashboard', compact('payments', 'bookings'));
    }

    public function teacher()
    {
        return view('admin.teacher_dashboard');
    }

    public function student()
    {
        return view('admin.student_dashboard');
    }
}
