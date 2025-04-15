<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(){
        $services = Service::get();
        return view('admin.services.index', compact('services'));
    }

    public function create(){
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
        ]);

        $services = Service::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('available-services.index')->with('success', 'Service Created Successfully');
    }

    public function show(string $id)
    {
         $service = Service::find($id);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $service = Service::find($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
        ]);

        $service = Service::find($id);

        $service->update([

        'name' => $request->input('name'),
        'description' => $request->input('description'),

        ]);
        return redirect()->route('available-services.index')->with('success', 'Service Edit Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $service = Service::find($id);
         $service->delete();
        return redirect()->route('available-services.index')->with('success', 'Service Deleted Successfully');
    }
}
