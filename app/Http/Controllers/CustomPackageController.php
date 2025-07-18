<?php

namespace App\Http\Controllers;

use App\Models\CustomPackage;
use App\Models\ServiceProviderCondition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CustomPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = CustomPackage::where('user_id', Auth::id())->get();

        return view('custom-packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $provider)
    {
        $condition = ServiceProviderCondition::where('service_provider_id', $provider->id)->first();

        return view('custom-packages.create', compact('provider', 'condition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $provider)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'price' => 'required|numeric',
        ]);

        $package = CustomPackage::create([
            'service_provider_id' => $provider->id,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'features' => $request->features,
            'price' => $request->price,
        ]);

        return redirect()->route('custom-packages.show', $package);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomPackage $customPackage)
    {
        return view('custom-packages.show', compact('customPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomPackage $customPackage)
    {
        return view('custom-packages.edit', compact('customPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomPackage $customPackage)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'price' => 'required|numeric',
        ]);

        $customPackage->update($request->only('name', 'description', 'features', 'price'));

        return redirect()->route('custom-packages.show', $customPackage)->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomPackage $customPackage)
    {
        $customPackage->delete();

        return redirect()->route('custom-packages.index')->with('success', 'Deleted');
    }

    public function pay(CustomPackage $customPackage)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntent = PaymentIntent::create([
            'amount' => $customPackage->price * 100,
            'currency' => 'usd',
        ]);

        $customPackage->update(['stripe_payment_id' => $paymentIntent->id]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }
}
