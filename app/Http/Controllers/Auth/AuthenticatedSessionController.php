<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Process a login request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Retrieve only the credentials that were validated
        $credentials = $request->validated();

        // Ensure the user exists and is approved
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // Let the default failed response handle "user not found"
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        if ($user->status !== User::STATUS_APPROVED) {
            // Custom messages for non-approved statuses
            $message = match ($user->status) {
                User::STATUS_PENDING => 'Your account is pending approval.',
                User::STATUS_REJECTED => 'Your account request was rejected.',
                default => trans('auth.failed'),
            };

            throw ValidationException::withMessages([
                'email' => [$message],
            ]);
        }

        // Attempt authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // If we reach here, credentials were invalid
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
