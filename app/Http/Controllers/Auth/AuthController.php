<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Auth;
use Log;

class AuthController extends Controller
{
    public function loginshow(){
        return view('auth.login');
    }

    public function registershow(){
        return view('auth.register');
    }

    public function register(Request $request)
{
    // dd($request->all());
    // Validate
    $this->validate($request, [
        'username' => ['required', 'alpha_num', 'max:255'],
        'fname' => ['required', 'string', 'max:255'],
        'lname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    // Create user
   $data = User::create([
        'username' => $request->username,
        'fname' => $request->fname,
        'lname' => $request->lname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    dd($data);

    // Redirect
    return redirect()->route('login')->with('success', 'Registration successful!');
}



    public function login(Request $request){
        $this->validate($request, [
            'email' => ['required','string','email','max:255'],
            'password' => ['required','string','min:8'],
        ]);

        $credentials = $request->only('email', 'password');

        if(auth()->attempt($credentials)){
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Invalid credentials!');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('/login');
    }

    public function dashboard(){
       if(Auth::check()){
        return view('admin.dashboard');
       }else{
        return redirect()->route('login');

    }

}
}
