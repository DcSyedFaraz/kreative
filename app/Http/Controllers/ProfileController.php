<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Check if a new password is provided and not empty.
        if (!empty($data['password'])) {
            // Hash the new password before updating.
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remove the password field if it's empty so it won't override the existing value.
            unset($data['password']);
        }

        // Update the user's attributes.
        $user->fill($data);

        // If the email has changed, reset the email verification time.
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Persist changes to the database.
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully.');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
