<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function teacher(){
        return view('admin.teacher_dashboard');
    }

    public function student(){
        return view('admin.student_dashboard');
    }
}
