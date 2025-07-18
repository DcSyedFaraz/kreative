<?php

namespace App\Http\Controllers;

use App\Models\ServiceProviderCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceProviderConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $condition = ServiceProviderCondition::where('service_provider_id', Auth::id())->first();

        return view('provider.conditions.edit', compact('condition'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'conditions' => 'required|string',
            'base_price' => 'required|numeric',
        ]);

        ServiceProviderCondition::updateOrCreate(
            ['service_provider_id' => Auth::id()],
            [
                'conditions' => $request->conditions,
                'base_price' => $request->base_price,
            ]
        );

        return redirect()->route('provider.conditions.edit')->with('success', 'Conditions saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceProviderCondition $serviceProviderCondition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceProviderCondition $serviceProviderCondition)
    {
        return view('provider.conditions.edit', ['condition' => $serviceProviderCondition]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceProviderCondition $serviceProviderCondition)
    {
        $request->validate([
            'conditions' => 'required|string',
            'base_price' => 'required|numeric',
        ]);

        $serviceProviderCondition->update($request->only('conditions', 'base_price'));

        return redirect()->route('provider.conditions.edit')->with('success', 'Conditions updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceProviderCondition $serviceProviderCondition)
    {
        //
    }
}
