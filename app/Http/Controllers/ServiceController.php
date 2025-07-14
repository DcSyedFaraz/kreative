<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Service;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Models\Payment;
use Log;
use Stripe\PaymentIntent;

class ServiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $allServices = Service::where('is_active', true)->get();
        $userServices = $user->services->pluck('id')->toArray();

        return view('services.index', compact('user', 'allServices', 'userServices'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'services' => 'sometimes|array',
            'services.*' => 'exists:services,id',
            'display_services' => 'sometimes|array',
            'display_services.*' => 'exists:services,id',
        ]);

        $user = Auth::user();

        // First detach all existing services
        $user->services()->detach();

        // Then attach the selected ones with proper display_on_profile value
        if ($request->has('services')) {
            foreach ($request->services as $serviceId) {
                $displayOnProfile = in_array($serviceId, $request->display_services ?? []);
                $user->services()->attach($serviceId, ['display_on_profile' => $displayOnProfile]);
            }
        }

        return redirect()->route('services.index')->with('success', 'Services updated successfully');
    }
    public function searchProviders(Request $request)
    {
        // Retrieve the search term from the query string
        $query = $request->input('query');

        $providers = User::with(['profile', 'services'])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('profile', function ($q) use ($query) {
                    $q->where('display_name', 'LIKE', "%{$query}%");
                });
            })
            ->has('profile')->get();

        // Return the view with the list of providers (and the original query if needed)
        return view('frontend.search-providers', compact('providers'));
    }

    public function show($id)
    {

        $provider = User::with(['profile', 'services', 'packages'])
            ->findOrFail($id);

        $bookings = Booking::select('booking_date')->get();

        // dd($bookings);

        return view('frontend.provider-detail', compact('provider', 'bookings'));
    }

}
