<?php

namespace App\Http\Controllers;

use App\Models\CustomPackage;
use App\Models\ServiceProviderCondition;
use App\Models\PackageOption;
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
        $packages = CustomPackage::where('user_id', Auth::id())->with('provider')->get();
        return view('custom-packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $provider)
    {
        $condition = ServiceProviderCondition::where('service_provider_id', $provider->id)->first();
        $options = PackageOption::where('service_provider_id', $provider->id)->get();

        return view('custom-packages.create', compact('provider', 'condition', 'options'));
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
            'options' => 'nullable|array',
        ]);

        $selectedOptions = [];
        $price = 0;
        if ($request->options) {
            foreach ($request->options as $optionId => $qty) {
                $option = PackageOption::find($optionId);
                $quantity = (int) $qty;
                if ($option && $quantity > 0) {
                    $selectedOptions[] = [
                        'option_id' => $option->id,
                        'name' => $option->name,
                        'quantity' => $quantity,
                        'unit_price' => $option->base_price,
                    ];
                    $price += $option->base_price * $quantity;
                }
            }
        }

        $package = CustomPackage::create([
            'service_provider_id' => $provider->id,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'features' => $request->features,
            'options' => $selectedOptions,
            'price' => $price,
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
        $options = PackageOption::where('service_provider_id', $customPackage->service_provider_id)->get();
        return view('custom-packages.edit', compact('customPackage', 'options'));
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
            'options' => 'nullable|array',
        ]);

        $selectedOptions = [];
        $price = 0;
        if ($request->options) {
            foreach ($request->options as $optionId => $qty) {
                $option = PackageOption::find($optionId);
                $quantity = (int) $qty;
                if ($option && $quantity > 0) {
                    $selectedOptions[] = [
                        'option_id' => $option->id,
                        'name' => $option->name,
                        'quantity' => $quantity,
                        'unit_price' => $option->base_price,
                    ];
                    $price += $option->base_price * $quantity;
                }
            }
        }

        $customPackage->update([
            'name' => $request->name,
            'description' => $request->description,
            'features' => $request->features,
            'options' => $selectedOptions,
            'price' => $price,
        ]);

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

    public function pay(Request $request, CustomPackage $customPackage)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // You might also re-retrieve the PaymentIntent server‑side
        // to verify status == 'succeeded', if you like.

        $customPackage->update([
            'payment_status' => 'completed',
            'stripe_payment_id' => $request->payment_intent_id,
        ]);

        return redirect()
            ->route('custom-packages.show', $customPackage)
            ->with('success', 'Payment completed successfully');
    }
}
