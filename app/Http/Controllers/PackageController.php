<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('items')->whereHas('items', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'features' => 'required|array',
            'features.*' => 'required|string',
        ]);

        $userId = Auth::id();

        $packageCount = Package::where('user_id', $userId)->count();

        if ($packageCount >= 3) {
            return redirect()->back()->with('error', 'You can only create up to 3 packages.');
        }

        $package = Package::create([
            'user_id' => $userId,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        foreach ($request->features as $feature) {
            PackageItem::create([
                'package_id' => $package->id,
                'features' => $feature,
            ]);
        }

        return redirect()->route('packages.index')->with('success', 'Package created successfully.');
    }

    public function edit($id)
    {
        $package = Package::with('items')->find($id);
        $selectedFeatures = $package->items->pluck('features')->filter()->toArray();
        return view('admin.packages.edit', compact('package', 'selectedFeatures'));
    }

    public function update(Request $request, $id)
    {
        //  dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'features' => 'required|array',
            'features.*' => 'required|string',
        ]);

        $package = Package::findOrFail($id);
        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Delete old features
        PackageItem::where('package_id', $package->id)->delete();

        // Add new features
        foreach ($request->features as $feature) {
            PackageItem::create([
                'package_id' => $package->id,
                'user_id' => Auth::id(),
                'features' => $feature,
            ]);
        }

        return redirect()->route('packages.index')->with('success', 'Package updated successfully.');
    }

    public function show($id)
    {
        $package = Package::with('items')->findOrFail($id);
        $selectedPackage = $package->items->pluck('features');
        return view('admin.packages.show', compact('package', 'selectedPackage'));
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted.');
    }
}

