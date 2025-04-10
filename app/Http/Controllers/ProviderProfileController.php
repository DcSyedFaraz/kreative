<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Auth;
use Illuminate\Http\Request;
use Storage;

class ProviderProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        return view('profile.index', compact('user', 'profile'));
    }

    public function personalInfo()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        return view('profile.personal-info', compact('user', 'profile'));
    }

    public function updatePersonalInfo(Request $request)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        $profile->display_name = $request->display_name;
        $profile->email = $request->email;
        $profile->phone_number = $request->phone_number;
        $profile->address = $request->address;
        $profile->save();

        return redirect()->route('profile.personal-info')->with('success', 'Personal information updated successfully');
    }

    public function profilePicture()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        return view('profile.profile-picture', compact('user', 'profile'));
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if ($profile->profile_picture) {
            Storage::delete("public/profile-pictures/{$profile->profile_picture}");
        }

        $fileName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->storeAs('public/profile-pictures', $fileName);

        $profile->profile_picture = $fileName;
        $profile->save();

        return redirect()->route('profile.profile-picture')->with('success', 'Profile picture updated successfully');
    }

    public function businessInfo()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        return view('profile.business-info', compact('user', 'profile'));
    }

    public function updateBusinessInfo(Request $request)
    {
        $request->validate([
            'shop_address' => 'required|string|max:255',
            'service_area' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        $profile->shop_address = $request->shop_address;
        $profile->service_area = $request->service_area;
        $profile->save();

        return redirect()->route('profile.business-info')->with('success', 'Business information updated successfully');
    }
}
