<?php

namespace App\Http\Controllers;

use App\Models\PackageOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageOptionController extends Controller
{
    public function index()
    {
        $options = PackageOption::where('service_provider_id', Auth::id())->get();
        return view('provider.package-options.edit', compact('options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'options' => 'required|array',
            'options.*.name' => 'required|string',
            'options.*.base_price' => 'required|numeric',
        ]);

        PackageOption::where('service_provider_id', Auth::id())->delete();

        foreach ($request->options as $option) {
            PackageOption::create([
                'service_provider_id' => Auth::id(),
                'name' => $option['name'],
                'base_price' => $option['base_price'],
            ]);
        }

        return redirect()->route('package-options.edit')->with('success', 'Options saved.');
    }
}
