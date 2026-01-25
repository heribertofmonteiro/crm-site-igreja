<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::paginate(10);
        return view('admin.patrimony.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patrimony.assets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'acquisition_date' => 'required|date',
            'status' => 'required|in:active,inactive,maintenance,disposed',
            'location' => 'nullable|string|max:255',
        ]);

        Asset::create($request->all());

        return redirect()->route('patrimony.assets.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return view('admin.patrimony.assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        return view('admin.patrimony.assets.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'acquisition_date' => 'required|date',
            'status' => 'required|in:active,inactive,maintenance,disposed',
            'location' => 'nullable|string|max:255',
        ]);

        $asset->update($request->all());

        return redirect()->route('patrimony.assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('patrimony.assets.index')->with('success', 'Asset deleted successfully.');
    }
}
